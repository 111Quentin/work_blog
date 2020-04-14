<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>注册页面</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="http://v3.bootcss.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://v3.bootcss.com/examples/signin/signin.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <form class="form-signin" method="POST" action="{{URL('/admin/register')}}">
            {{csrf_field()}}
            <h2 class="form-signin-heading">请注册</h2>
            <label for="name" class="sr-only">名字</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="名字" required autofocus>
            <label for="inputEmail" class="sr-only">邮箱</label>
            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="邮箱" required autofocus>
            <label for="inputPassword" class="sr-only">密码</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="输入密码" required>
            <label class="sr-only">重复密码</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="重复输入密码" required>
            <label for="captcha" class="sr-only">验证码</label>
            <input type="text" name="captcha" id="captcha" class="form-control" placeholder="请输入验证码" required>
            <img src="{{captcha_src()}}" alt="验证码" id="img" onclick="this.src='{{captcha_src()}}?'+Math.random()" style="margin: 20px 0px;">
            @include('admin.layout.error')
            <button class="btn btn-lg btn-primary btn-block" type="submit">注册</button>
            <a href="/admin/login" class="btn btn-lg btn-primary btn-block" type="submit">去登录>></a>
        </form>

    </div> <!-- /container -->

</body>
</html>
