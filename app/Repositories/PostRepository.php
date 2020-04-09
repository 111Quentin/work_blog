<?php
namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Model\Admin\Post;
use App\Http\Requests;

class PostRepository extends  BaseRepository
{
    public function model(){
        return Post::class;
    }

    /**
     * 文章搜索
     */
    public function postSearch($query)
    {
        if(preg_match('/\d+/', $query)){
            $posts = Post::where('created_at', 'like', '%' . $query . '%')->paginate(10);
        }
        else{
            $posts = Post::where('title', 'like', '%' . $query . '%')->orWhere('author', 'like' , '%' . $query . '%')->paginate(10);
        }
        return $posts;
    }
}