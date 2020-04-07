<?php
    namespace  App\Http\Controllers\Admin;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;

    class PostController extends Controller{
        //登录页面
        public function index(){
            return view('admin.post.index');
        }


    }