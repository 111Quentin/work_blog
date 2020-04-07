<?php
    namespace  App\Http\Controllers\Admin;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
//   use App\Model\Admin\User;

    class LoginController extends Controller{
        /**
         * 登录页面
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function index(){
            return view('admin.login.index');
        }

        /**
         * 登录
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function login(Request $request){
            $this->validate($request,[
                'email' => 'required|email',
                'password' => 'required|min:6|max:30',
                'captcha'   =>  'required|captcha'
            ]);
            $user                   =   request(['email','password']);
            $UserModel              =   new \App\Model\Admin\User();
            $code                   =   $UserModel->checkLogin($user);
            switch ($code){
                case '1':
                            return redirect('/posts');
                            break;
                case '0':
                            return redirect('/admin/login')->withErrors([
                                'loginError' => '无此用户'
                            ]);
                            break;
                case '-1':
                            return redirect('/admin/login')->withErrors([
                                'loginError' => '登陆错误次数过多，请于10分钟后登陆'
                            ]);
                            break;
                default:
                            return redirect('/admin/login')->withErrors([
                                'loginError' => '登录邮箱或密码错误'
                            ]);
                            break;
            }
        }

        /**
         * 退出登录
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function logout(){
            \Auth::guard('web')->logout();
            return redirect('/admin/login');
        }
    }