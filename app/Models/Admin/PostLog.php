<?php

namespace  App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Post;

class PostLog extends  Model
{
    /**
     * @var string
     */
    protected $table = 'posts_log';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
       'post_id','user_id','action','cycle','content','title','desc','ip','create_time'
    ];

    /**
     * 保存日志
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
