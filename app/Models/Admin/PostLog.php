<?php

namespace  App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Post;

class PostLog extends  Model
{
    // 指定与当前模块关联的数据表
    protected $table = 'posts_log';

    public $timestamps = false;

    // 填充字段
    protected $fillable= [
       'post_id','user_id','action','cycle','content','title','desc','ip','create_time'
    ];

    /**
     * @param \App\Models\Admin\Post $post
     * @param string $action
     * @param string $cycle
     * @return mixed
     */
    public  function saveLog(Post $post, string $action, string $cycle)
    {
        $data['post_id']        = $post->id ? : 0;
        $data['user_id']        = $post->user_id;
        $data['action']         = $action;
        $data['cycle']          = $cycle;
        $data['content']        = $post->content;
        $data['title']          = $post->title;
        $data['desc']           = $post->desc;
        $data['ip']             = $_SERVER['REMOTE_ADDR'];
        $data['create_time']    = time();
        return $this->create($data);
    }
}
