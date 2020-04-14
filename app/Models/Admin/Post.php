<?php
namespace  App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\Admin\User;
use App\Http\Requests;
use App\Models\Admin\PostLog;

class Post extends  Model
{
    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var array
     */
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

    /**
     * 字段查询
     * @param $query
     * @param $key
     * @return mixed
     */
    public function scopeBySearch($query, $key)
    {
        if ($key) {
            return $query->where('title', 'like', '%' . $key . '%')->orWhere('author', 'like' , '%' . $key . '%')->orWhere('desc', 'like' , '%' . $key . '%');
        }
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
