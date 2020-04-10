<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostCheck;
use App\Http\Requests\PostSeachCheck ;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePostCheck;
use App\Model\Admin\Post;
use App\Repositories\PostRepository;
use App\Services\PostService;
use App\Http\Requests;
use App\Criteria\PostCriteria;

class PostController extends Controller
{
    private $postService;

    private $postCriteria;

    public function __construct(PostRepository $postRepository)
    {
        $this->postService = new PostService($postRepository);
        $this->postCriteria = $postRepository;
    }

    public function index()
    {
        $posts = $this->postService->getPosts();
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

    public function search(PostSeachCheck $request)
    {
        $query = request('query');
        $posts = $this->postService->postSearch($query);
        //在控制器使用Criteria
//        $criteria = $this->postCriteria->pushCriteria(new PostCriteria());
//        dd($this->postCriteria->all());
        return view('admin.post.search', compact('posts', 'query'));
    }
}
