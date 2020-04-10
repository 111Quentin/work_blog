<?php
namespace  App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterPost;
use App\Repositories\UserRepository;
use App\Services\UserService;

class RegisterController extends Controller
{
    private $userService;

    public  function __construct(UserRepository $userRepository)
    {
        $this->userService = new UserService($userRepository);
    }

    //注册页面
    public function index()
    {
        return view('admin.register.index');
    }
    //注册
    public function register(RegisterPost $request)
    {
        $res = $this->userService->register();
        if ($res) {
            return redirect('/admin/login');
        } else {
            return redirect('/admin/register')->withErrors([
                'registerError' => '同个ip1分钟内只能注册一个账号'
            ]);
        }
    }
}