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


class PostController extends Controller
{
    private $postService;

    public function __construct(PostRepository $postRepository)
    {
        $this->postService = new PostService($postRepository);
    }

    public function index(PostRepository $postRepository)
    {
        $postRepository->pushCriteria(new RoleCriteria());
        $posts = $postRepository->scopeQuery(function ($query){
            return $query->orderby('id', 'desc');
        })->paginate();
        return view('admin.post.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.post.create');
    }

    public function store(PostCheck $request)
    {
        $this->postService->storePosts();
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
        $this->postService->updatePost($post);
        return redirect("/posts/{$post->id}");
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $this->postService->postDel($post['id'], $post);
        return redirect("/posts");
    }

    public function search(PostRepository $postRepository)
    {
        $posts = $postRepository->paginate();
        return view('admin.post.search', compact('posts'));
    }
}
