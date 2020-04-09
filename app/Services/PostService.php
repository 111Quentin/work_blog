<?php
/**
 * Created by PhpStorm
 * User: Quentin
 * Date: 2020/4/9
 * Time: 19:22
 */
namespace App\Services;
use App\Repositories\PostRepository;

class PostService
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }


    public function postSearch($query)
    {
        return $this->postRepository->postSearch($query);
    }
}
