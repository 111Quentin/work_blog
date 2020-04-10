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

    public function scopeByRole($query, $user)
    {
        return $query->where('user_id', $user->id);
    }

}
