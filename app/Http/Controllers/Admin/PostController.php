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
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index(){
        //使用Criteria优化搜索
        $this->postRepository->pushCriteria(new RoleCriteria());
        $posts = $this->postRepository->scopeQuery(function ($query){
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
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $data['author']  = $request->user()->name;
        $post = $this->postRepository->create($data);
        return redirect("/posts/{$post->id}");
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
        $data               = $request->all();
        $data['updated_at'] = date("Y-m-d H:i:s",time());
        $this->postRepository->update($data, $post->id);
        return redirect("/posts/{$post->id}");
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $this->postRepository->delete($post->id);
        return redirect("/posts");
    }

    public function search(Request $request)
    {
        //使用Criteria优化搜索
        $this->postRepository->pushCriteria(new SearchCriteria($request));
        $posts = $this->postRepository->scopeQuery(function ($query){
            return $query->orderby('created_at', 'desc');
        })->paginate();
        $query = request('query');
        return view('admin.post.search', compact('posts', 'query'));
    }
}
