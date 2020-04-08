@extends("admin.layout.main")

@section("content")
    <div class="col-sm-8 blog-main">
        <div style="height: 20px;">
        </div>
        <div>
            @foreach($posts as $post)
                <div class="blog-post">
                    <h2 class="blog-post-title"><a href="/posts/{{$post->id}}" >{{$post->title}}</a></h2>
                    <p class="blog-post-meta">{{$post->created_at->toFormattedDateString()}} by <a href="/user/{{$post->user_id}}">{{$post->author}}</a></p>
                    {!! str_limit($post->content, 100, '...') !!}
                </div>
            @endforeach
            {{$posts->links()}}
        </div><!-- /.blog-main -->
    </div>
@endsection