<?php
namespace  App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Admin\User;
use App\Http\Requests\RegisterPost;

class RegisterController extends Controller
{
    //注册页面
    public function index()
    {
        return view('admin.register.index');
    }
    //注册
    public function register(RegisterPost $request)
    {
        $res = (new User())->register();
        if ($res) {
            return redirect('/admin/login');
        } else {
            return redirect('/admin/register')->withErrors([
                'registerError' => '注册失败'
            ]);
        }
    }
}