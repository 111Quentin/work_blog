<?php
namespace  App\Http\Controllers\Admin;

use App\Http\Requests\LoginPost;
use App\Http\Controllers\Controller;
use Auth;
use App\Repositories\UserRepository;


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
//        return $this->userReposity->checkLogin();
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