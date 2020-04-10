<?php
namespace  App\Http\Controllers\Admin;

use App\Http\Requests\LoginPost;
use App\Http\Controllers\Controller;
use Auth;
use App\Repositories\UserRepository;
use App\Services\UserService;

class LoginController extends Controller
{
    private $userService;

    public  function __construct(UserRepository $userRepository)
    {
        $this->userService = new UserService($userRepository);
    }

    /**
     * 登录页面
     */
    public function index()
    {
        return view('admin.login.index');
    }

    /**
     * 登录
     */
    public function login(LoginPost $request)
    {
        $code = $this->userService->checkLogin();
        switch ($code){
            case '1':
                return redirect('/posts');
                break;
            case '0':
                return redirect('/admin/login')->withErrors([
                    'loginError' => '无此用户'
                ]);
                break;
            case '-1':
                return redirect('/admin/login')->withErrors([
                    'loginError' => '登陆错误次数过多，请于10分钟后登陆'
                ]);
                break;
            default:
                return redirect('/admin/login')->withErrors([
                    'loginError' => '登录邮箱或密码错误'
                ]);
                break;
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/admin/login');
    }
}