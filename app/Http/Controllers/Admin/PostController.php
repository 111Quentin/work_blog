<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostCheck;
use App\Http\Requests\PostSeachCheck ;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePostCheck;
use App\Model\Admin\Post;
use App\Repositories\PostRepository;
use App\Services\PostService;
use Illuminate\Http\Request;
use App\Criteria\RoleCriteria;
use App\Criteria\SearchCriteria;
use Illuminate\Http\Request as Req;

class PostController extends Controller
{
    private $postService;

    private $req;

    public function __construct(PostRepository $postRepository, Req $req)
    {
        $this->postService = new PostService($postRepository);
        $this->req = $req;
    }

    public function index(PostRepository $postRepository)
    {
        //使用Criteria优化搜索
        $postRepository->pushCriteria(new RoleCriteria());
        $posts = $postRepository->scopeQuery(function ($query){
            return $query->orderby('created_at', 'desc');
        })->paginate();
        return view('admin.post.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.post.create');
    }

    public function store(PostCheck $request)
    {
        $this->postService->storePosts($this->req);
        return redirect('/posts');
    }

    public function show(Post $post)
    {
        return view('admin.post.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('admin.post.edit', compact('post'));
    }

    public function update(UpdatePostCheck $request, Post $post)
    {
        $this->authorize('update', $post);
        $this->postService->updatePost($post, $this->req);
        return redirect("/posts/{$post->id}");
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $this->postService->postDel($post['id'], $post);
        return redirect("/posts");
    }

    public function search(PostRepository $postRepository, Request $request)
    {
        //使用Criteria优化搜索
        $postRepository->pushCriteria(new SearchCriteria($request));
        $posts = $postRepository->scopeQuery(function ($query){
            return $query->orderby('created_at', 'desc');
        })->paginate();
        return view('admin.post.search', compact('posts'));
    }
}
