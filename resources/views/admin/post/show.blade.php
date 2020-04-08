
@extends("admin.layout.main")

@section("content")

    <div class="col-sm-8 blog-main">
        <div class="blog-post">
            <div style="display:inline-flex">
                <h2 class="blog-post-title">{{$post->title}}</h2>

                    <a style="margin: auto"  href="/posts/{{$post->id}}/edit">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                    <a style="margin: auto"  href="/posts/{{$post->id}}/delete">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </a>
            </div>
            <br>
            <h3 class="blog-post-mata" style="margin: 10px 0;">{{$post->desc}}</h3>
            <p class="blog-post-meta">{{$post->created_at->toFormattedDateString()}} by <a href="#">{{$post->author}}</a></p>
            <p>{!! $post->content !!}</p>
        </div>

    </div><!-- /.blog-main -->



@endsection