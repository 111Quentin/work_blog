<?php
namespace  App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterPost;
use App\Repositories\UserRepository;


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
     * @return bool
     */
    public function register(RegisterPost $request)
    {
        return $this->userReposity->register();
    }
}