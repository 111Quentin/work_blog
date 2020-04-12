<?php
/**
 * Created by PhpStorm
 * User: Quentin
 * Date: 2020/4/9
 * Time: 19:22
 */

namespace App\Services;

use App\Repositories\PostRepository;
use Illuminate\Http\Request;

class PostService
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * 获取文章
     * @return mixed
     */
    public function  getPosts()
    {
        return $this->postRepository->getPosts();
    }

    /**
     * 新增文章
     * @return bool
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function storePosts(Request $request)
    {
        return $this->postRepository->storePosts($request);
    }

    /**
     * 修改文章
     * @param $post
     * @return bool
     */
    public function updatePost($post, Request $request)
    {
        return $this->postRepository->updatePost($post, $request);
    }

    /**
     * 删除文章
     * @param $id
     * @param $post
     * @return bool
     */
    public function postDel($id,$post)
    {
        return $this->postRepository->postDel($id, $post);
    }

    /**
     * 文章搜索
     * @param $query
     * @return mixed
     */
    public function postSearch($query)
    {
        return $this->postRepository->postSearch($query);
    }

}
