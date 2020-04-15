<?php
namespace  App\Models\Admin;

use App\Models\Admin\PostLog;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\Admin\User;
use Illuminate\Http\Request;

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

    /**
     * 监听模型事件
     */
    public static function boot()
    {
        // 新增模型数据前触发
        static::creating(function ($post) {
            (new PostLog())->saveLog(
                $post,
                'insert',
                'created'
            );
        });

        // 新增模型数据后触发
        static::created(function ($post) {
            (new PostLog())->saveLog(
                $post,
                'insert',
                'created'
            );
        });

        // 更新模型数据前触发
        static::updating(function ($post) {
            (new PostLog())->saveLog(
                $post,
                'update',
                'updating'
            );
        });

        // 更新模型数据后触发
        static::updated(function ($post) {
            (new PostLog())->saveLog(
                $post,
                'update',
                'updated'
            );
        });

        // 删除模型数据前触发
        static::deleting(function ($post) {
            (new PostLog())->saveLog(
                $post,
                'delete',
                'deleting'
            );
        });

        // 删除模型数据后触发
        static::deleted(function ($post) {
            (new PostLog())->saveLog(
                $post,
                'delete',
                'deleted'
            );
        });
    }


}
