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


    /**
     * 只查看本人博客
     * @param $query
     * @param $user
     * @return mixed
     */
    public function scopeByRole($query, $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeBySearch($query, $key)
    {
        if ($key) {
            return $query->where('title', 'like', '%' . $key . '%')->orWhere('author', 'like' , '%' . $key . '%')->orWhere('desc', 'like' , '%' . $key . '%');
        }
        return $query->where('id', '<', 0);
    }

    /**
     * 常用scope
     * @param $query
     * @return mixed
     */
    public function scopeRecent($query)
    {
        return $query->orderby('created_at','desc');
    }

}
