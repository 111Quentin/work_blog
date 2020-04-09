<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostCheck;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePostCheck;
use App\Model\Admin\Post;
use DB;

class PostController extends Controller
{
    
    public function index()
    {
        $posts = (new Post())->getPosts();
        return view('admin.post.index', compact('posts'));
    }


    public function create()
    {
        return view('admin.post.create');
    }

    public function store(PostCheck $request)
    {
        (new Post())->storePosts();
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
        $post->updatePost();
        return redirect("/posts/{$post->id}");
    }


    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->postDel($post['id'], $post);
        return redirect("/posts");
    }

    /**
     * 搜索
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $this->validate(request(), [
            'query' => 'required'
        ]);
        $query = request('query');
        if(preg_match('/\d+/', $query)){
            $posts = Post::where('created_at', 'like', '%' . $query . '%')->paginate(10);
        }
        else{
            $posts = Post::where('title', 'like', '%' . $query . '%')->orWhere('author', 'like' , '%' . $query . '%')->paginate(10);
        }
        return view('admin.post.search', compact('posts', 'query'));
    }
}
