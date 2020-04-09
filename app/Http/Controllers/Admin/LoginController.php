<?php
namespace  App\Http\Controllers\Admin;

use App\Http\Requests\LoginPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\User;
use Auth;

class LoginController extends Controller
{
    /**
     * 登录页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.login.index');
    }

    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(LoginPost $request)
    {
        $code = (new User())->checkLogin();
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