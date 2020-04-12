<?php
namespace  App\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Model\Admin\User;
use App\Http\Requests;
use App\Model\Admin\PostLog;

class Post extends  Model
{
    // 指定与当前模块关联的数据表
    protected $table = 'posts';

    // 填充字段
    protected $fillable= [
       'title', 'desc','content', 'user_id','author','create_time'
    ];

    //内聚Scope(限定只能查看自己的文章)
    public function scopeByRole($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeBySearch($query, $key)
    {
        if ($key) {
            return $query->where('title', 'like', '%' . $key . '%')->orWhere('author', 'like' , '%' . $key . '%')->orWhere('desc', 'like' , '%' . $key . '%');
        }
        return $query->where('id', '<', 0);
    }

}
