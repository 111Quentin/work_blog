<?php

namespace App\Repositories;

use App\Model\Admin\LoginLog;
use phpDocumentor\Reflection\Types\This;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Model\Admin\User;
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
    public function register()
    {
        $data                      = array();
        $data['password']          = bcrypt(request('password'));
        $data['name']              = request('name');
        $data['email']             = request('email');
        $data['ip']                = $_SERVER['REMOTE_ADDR'];
        $data['created_at']        = date("Y-m-d H:i:s", time());
        //每次客户端新增判断一下是否有ip存在，而且是否1分钟内再注册
        $ip = $this->model->where('ip', '=', $data['ip'])->orderBy('created_at', 'desc')->first();
        if (isset($ip) && time() - strtotime($ip->toArray()['created_at']) < 60) {
            return false;
        } else {
            $this->model->insert($data);
            return true;
        }
    }

    /**
     * 检查登录
     */
    public function checkLogin()
    {
        $user                   =   request(['email', 'password']);
        $data                   =   array();
        $data['email']          =   $user['email'];
        $data['ip']             =   $_SERVER['REMOTE_ADDR'];
        $data['create_time']    =   time();
        //检查是否有此用户
        $userInfo = $this->skipCriteria()->where('email', $user['email'])->first();
        //统计登录错误次数
        $logMins = time() - 10 * 60;
        $loginCounts = LoginLog::where('email', $user['email'])->where('create_time', '>=', $logMins)->count();
        //登录成功
        if (true == Auth::guard('web')->attempt($user) && $loginCounts < 5) {
            //记录登录成功日志
            $data['login_type'] = 'suc';
            event( new UserLogin($data) );
            return 1;
        } else if(empty($userInfo)) {  //无此用户
            return 0;
        } else if($loginCounts >= 5) {
            return -1;
        } else {
            $data['login_type'] = 'fail';
            event( new UserLogin($data) );
            return -2;
        }
    }
}