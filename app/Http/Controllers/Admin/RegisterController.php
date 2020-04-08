<?php
namespace  App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\User;

class RegisterController extends Controller
{
    //注册页面
    public function index()
    {
        return view('admin.register.index');
    }
    //注册
    public function register()
    {
        $this->validate(request() ,[
            'name'              => 'required|min:3|unique:users,name',
            'email'             => 'required|unique:users,email|email',
            'password'          => 'required|min:6|max:30|confirmed',
            'captcha'           => 'required|captcha'
        ]);

        $data                   = array();
        $data['password']       = bcrypt(request('password'));
        $data['name']           = request('name');
        $data['email']          = request('email');
        $data['ip']             = $_SERVER['REMOTE_ADDR'];
        $data['created_at']     = date("Y-m-d H:i:s",time());

        //1每次客户端新增判断一下是否有ip存在，而且是否1分钟内再注册
        $ip = User::where('ip', '=', $data['ip'])->orderBy('created_at', 'desc')->first();
        if (isset($ip) && time() - strtotime($ip->toArray()['created_at']) < 60) {
            return redirect('/admin/register')->withErrors([
                'registerError' => '同个ip1分钟内只能注册一个账号'
            ]);
        }
        $res = User::insert($data);
        if ($res) {
            return redirect('/admin/login');
        } else {
            return redirect('/admin/register')->withErrors([
                'registerError' => '注册失败'
            ]);
        }
    }
}