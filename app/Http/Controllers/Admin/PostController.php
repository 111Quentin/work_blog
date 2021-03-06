<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostCheck;
use App\Http\Requests\UpdatePostCheck;
use App\Models\Admin\Post;
use App\Repositories\PostRepository;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var Request
     */
    private $request;

    public function __construct(PostRepository $postRepository, Request $request)
    {
        parent::__construct();
        $this->postRepository = $postRepository;
        $this->request = $request;
    }

    /**
     * 博客首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index(){
        $posts = $this->postRepository->recent()->paginate();
        return view('admin.post.index', compact('posts'));
    }

    /**
     * 博客新增页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.post.create');
    }

    /**
     * @param PostCheck $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PostCheck $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $data['author']  = $request->user()->name;
        $post = $this->postRepository->create($data);
        return redirect("/posts/{$post->id}");
    }

    /**
     * 博客详情页面
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Post $post)
    {
        $this->authorize('show', $post);
        return view('admin.post.show', compact('post'));
    }

    /**
     * 博客编辑页面
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Post $post)
    {
        $this->authorize('edit', $post);
        return view('admin.post.edit', compact('post'));
    }

    /**
     * 更新博客
     * @param UpdatePostCheck $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(UpdatePostCheck $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $this->request->all();
        $post->update($data);
        return redirect("/posts/{$post->id}");
    }

    /**
     * 删除博客
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect("/posts");
    }

    /**
     * 博客查询
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function search()
    {
        $posts = $this->postRepository->recent()->paginate();
        return view('admin.post.index', compact('posts'));
    }
}
