<?php
namespace  App\Http\Controllers\Admin;

use App\Http\Requests\LoginPost;
use App\Http\Controllers\Controller;
use Auth;
use App\Repositories\UserRepository;
use App\Services\UserService;

class LoginController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userReposity;

    public  function __construct(UserRepository $userRepository)
    {
        $this->userReposity = $userRepository;
    }

    /**
     * 登录页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.login.index');
    }

    /**
     * 账号登录
     * @param LoginPost $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(LoginPost $request)
    {
        $code = $this->userReposity->checkLogin();
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/admin/login');
    }
}