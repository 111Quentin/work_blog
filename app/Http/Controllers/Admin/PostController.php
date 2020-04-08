<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Post;
use App\Model\Admin\User;
use App\Model\Admin\PostLog;
use DB;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user()->toArray();
        if($user['name'] == 'admin'){
            $posts = Post::where('id','>',0)->orderBy('created_at', 'desc')->paginate(5);
        }else{
            $posts = Post::where('user_id',$user['id'])->orderBy('created_at', 'desc')->paginate(5);
        }
        return view('admin.post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:4|max:50',
            'desc' => 'required|min:4|max:100',
            'content' => 'required|min:10',
        ]);
        //获取登录用户信息
        $user   = User::where('id',\Auth::id())->first()->toArray();
        $params = array_merge(request(['title','desc' ,'content']), ['user_id' => \Auth::id(),'author' => $user['name'],'created_at' => date("Y-m-d H:i:s",time())]);
        $post   = Post::create($params)->toArray();
        //入库日志
        if($post){
            $data = array();
            $data['post_id'] = $post['id'];
            $data['user_id'] = \Auth::id();
            $data['action'] = 'insert';
            $data['title'] = request(['title'][0]);
            $data['desc'] = request(['desc'][0]);
            $data['content'] = request(['content'][0]);
            $data['ip'] = $_SERVER['REMOTE_ADDR'];
            $data['create_time'] = time();
            PostLog::insert($data);
        }
        return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'title' => 'required|min:4|max:50',
            'desc' => 'required|min:4|max:100',
            'content' => 'required|min:10',
        ]);
        //获取登录用户信息
        $user   = User::where('id',\Auth::id())->first()->toArray();
        $params = array_merge(request(['title','desc' ,'content']), ['user_id' => \Auth::id(),'author' => $user['name'],'updated_at' => date("Y-m-d H:i:s",time())]);
        $res = $post->update($params);
        //写入日志
        if($res){
            $data                       = array();
            $data['post_id']            = $post['id'];
            $data['user_id']            = \Auth::id();
            $data['action']             = 'update';
            $data['title']              = request(['title'][0]);
            $data['desc']               = request(['desc'][0]);
            $data['content']            = request(['content'][0]);
            $data['ip']                 = $_SERVER['REMOTE_ADDR'];
            $data['create_time']        = time();
            PostLog::insert($data);
        }
        return redirect("/posts/{$post->id}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $data = array();
        $data['post_id']     =      $post['id'];
        $data['user_id']     =      \Auth::id();
        $data['action']      =      'delete';
        $data['title']       =      $post['title'];
        $data['desc']        =      $post['desc'];
        $data['content']     =      $post['content'];
        $data['ip']          =      $_SERVER['REMOTE_ADDR'];
        $data['create_time'] =      time();
        PostLog::insert($data);
        Post::destroy($post['id']);
        return redirect("/posts");
    }

    /**
     * 搜索
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(){
        $this->validate(request(),[
            'query' => 'required'
        ]);
        $query = request('query');
        $posts = Post::where('title','like','%'.$query.'%')->orWhere('author','like','%'.$query.'%')->orWhere('created_at','like','%'.$query.'%')->paginate(10);
        return view('admin.post.search', compact('posts', 'query'));
    }
}
