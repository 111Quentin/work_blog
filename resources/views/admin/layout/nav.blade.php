<div class="blog-masthead">
    <div class="container">
        <form action="/posts/search" method="GET">
        <ul class="nav navbar-nav navbar-left">
            <li>
                <a class="blog-nav-item " href="/posts">首页</a>
            </li>
            <li>
                <a class="blog-nav-item" href="/posts/create">写文章</a>
            </li>

            <li style="width: 227px;">
                <input name="query" type="text" value="" class="form-control" style="margin-top:10px" placeholder="搜索时间格式如:2020-04-08">
            </li>
            <li>
                <button class="btn btn-default" style="margin-top:10px" type="submit">Go!</button>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <div>
                    <a href="#" class="blog-nav-item dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> {{Auth::guard('web')->user()->name}}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/admin/logout">登出</a></li>
                    </ul>
                </div>
            </li>
        </ul>
        </form>
    </div>
</div>
