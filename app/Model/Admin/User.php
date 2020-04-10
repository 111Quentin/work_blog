<?php
namespace  App\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Auth;
Use App\Http\Requests;

class User extends  Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    // 指定与当前模块关联的数据表
    protected $table = 'users';

    public $timestamps = true;

    // 填充字段
    protected $fillable= [
        'name', 'email', 'password','ip'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // 使用trait,相当于将整个trait代码复制过来(trait是php 5.4才有的语法,主要用于实现代码复用)
    use Authenticatable;

    /**
     * 注册
     */
    public function  register()
    {
        $data                   = array();
        $data['password']       = bcrypt(request('password'));
        $data['name']           = request('name');
        $data['email']          = request('email');
        $data['ip']             = $_SERVER['REMOTE_ADDR'];
        $data['created_at']     = date("Y-m-d H:i:s", time());

        //每次客户端新增判断一下是否有ip存在，而且是否1分钟内再注册
        $ip = self::where('ip', '=', $data['ip'])->orderBy('created_at', 'desc')->first();
        if (isset($ip) && time() - strtotime($ip->toArray()['created_at']) < 60) {
            return redirect('/admin/register')->withErrors([
                'registerError' => '同个ip1分钟内只能注册一个账号'
            ]);
        }
        return User::insert($data);
    }

    /**
     * 检查登录
     */
    public function checkLogin()
    {
        $user = request(['email', 'password']);
        $data                   =   array();
        $data['email']          =   $user['email'];
        $data['ip']             =   $_SERVER['REMOTE_ADDR'];
        $data['create_time']    =   time();
        //检查是否有此用户
        $userInfo = self::where('email', $user['email'])->first();
        //统计登录错误次数
        $logMins = time() - 10 * 60;
        $loginCounts = LoginLog::where('email', $user['email'])->where('create_time', '>=', $logMins)->count();
        //登录成功
        if (true == Auth::guard('web')->attempt($user) && $loginCounts < 5) {
            //记录登录成功日志
            $data['login_type'] = 'suc';
            LoginLog::insert($data);
            return 1;
        } else if(empty($userInfo)) {  //无此用户
            return 0;
        } else if($loginCounts >= 5) {
            return -1;
        } else {
            $data['login_type'] = 'fail';
            LoginLog::insert($data);
            return -2;
        }
    }

    public function isAdmin()
    {
        return $this->name == 'admin';
    }
}
