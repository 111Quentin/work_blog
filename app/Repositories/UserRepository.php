<?php

namespace App\Repositories;

use App\Models\Admin\LoginLog;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Admin\User;
use App\Http\Requests;
use Auth;
use App\Events\UserLogin;


class UserRepository extends  BaseRepository
{

    public function model()
    {
        return User::class;
    }

    /**
     * 注册
     * @return bool
     */
//    public function register()
//    {
//        $data                      = array();
//        $data['password']          = bcrypt(request('password'));
//        $data['name']              = request('name');
//        $data['email']             = request('email');
//        $data['ip']                = $_SERVER['REMOTE_ADDR'];
//        $data['created_at']        = date("Y-m-d H:i:s", time());
//        //每次客户端新增判断一下是否有ip存在，而且是否1分钟内再注册
//        $ip = $this->model->where('ip', '=', $data['ip'])->orderBy('created_at', 'desc')->first();
//
//        if (isset($ip) && time() - strtotime($ip->toArray()['created_at']) < 60) {
//            return redirect('/admin/register')->withErrors([
//                'registerError' => '同个ip1分钟内只能注册一个账号'
//            ]);
//        } else {
//            $this->model->insert($data);
//            return redirect()->to('/admin/login');
//        }
//    }

    /**
     * 检查登录
     */
//    public function checkLogin()
//    {
//        $user                   =   request(['email', 'password']);
//        $data                   =   array();
//        $data['email']          =   $user['email'];
//        $data['ip']             =   $_SERVER['REMOTE_ADDR'];
//        $data['create_time']    =   time();
//
//        //检查是否有此用户
//        $userInfo = $this->skipCriteria()->where('email', $user['email'])->first();
//
//        //统计登录错误次数
//        $logMins = time() - 10 * 60;
//        $loginCounts = LoginLog::where('email', $user['email'])->where('create_time', '>=', $logMins)->count();
//
//        if (true == Auth::guard('web')->attempt($user) && $loginCounts < 5) {
//            $data['login_type'] = 'suc';
//            event( new UserLogin($data) ); //记录登录成功日志
//            return redirect()->to('/posts');
//        } else if(empty($userInfo)) {
//            return redirect('/admin/login')->withErrors([
//                    'loginError' => '无此用户'
//                ]);
//        } else if($loginCounts >= 5) {
//            return redirect('/admin/login')->withErrors([
//                    'loginError' => '登陆错误次数过多，请于10分钟后登陆'
//                ]);
//        } else {
//            $data['login_type'] = 'fail';
//            return redirect('/admin/login')->withErrors([
//                    'loginError' => '登录邮箱或密码错误'
//                ]);
//        }
//    }
}