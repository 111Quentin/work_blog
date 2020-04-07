<?php
    namespace  App\Http\Controllers\Admin;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;

    class LoginController extends Controller{
        //登录页面
        public function index(){
            return view('admin.login.index');
        }

        //登录
        public function login(Request $request){
            $this->validate($request,[
                'email' => 'required|email',
                'password' => 'required|min:6|max:30',
                'captcha'   =>  'required|captcha'
            ]);
            $user = request(['email','password']);
            if(true == \Auth::guard('web')->attempt($user)){
                return redirect('/admin/post');
            }
            return redirect('/admin/login')->withErrors([
                'loginError' => '登录邮箱或密码错误'
            ]);

        }
    }