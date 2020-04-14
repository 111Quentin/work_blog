<?php
namespace  App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class PostLog extends  Model
{
    // 指定与当前模块关联的数据表
    protected $table = 'posts_log';

    public $timestamps = false;

    // 填充字段
    protected $fillable= [
       'post_id', 'user_id','action','content','ip','create_time', 'title', 'desc'
    ];





}
