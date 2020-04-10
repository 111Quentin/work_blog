<?php
/**
 * Created by PhpStorm
 * User: Quentin
 * Date: 2020/4/9
 * Time: 19:22
 */
namespace App\Services;
use App\Repositories\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * 注册
     * @return bool
     */
    public function register()
    {
        return $this->userRepository->register();
    }

    /**
     * 登录
     * @return int
     */
    public function checkLogin()
    {
        return $this->userRepository->checkLogin();
    }

}
