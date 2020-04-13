<?php
namespace  App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterPost;
use App\Repositories\UserRepository;
use App\Services\UserService;

class RegisterController extends Controller
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
     * 注册页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.register.index');
    }

    /**
     * 账号注册
     * @param RegisterPost $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(RegisterPost $request)
    {
        $res = $this->userReposity->register();
        if ($res) {
            return redirect('/admin/login');
        } else {
            return redirect('/admin/register')->withErrors([
                'registerError' => '同个ip1分钟内只能注册一个账号'
            ]);
        }
    }
}