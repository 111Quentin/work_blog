<?php

namespace App\Repositories;

use App\Criteria\RoleCriteria;
use App\Model\Admin\PostLog;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Model\Admin\Post;
use App\Model\Admin\User;
use Auth;

class PostRepository extends  BaseRepository
{

    public function model()
    {
        return Post::class;
    }

    /**
     * 可查询的字段
     * @return array
     */
    public function getSearchable()
    {
        return [
            'title'             => 'like',
            'author'            => 'like',
            'create_time'       => 'btwtime',
        ];
    }

    public function searchName($model, $value)
    {
        $user = User::where('name', $value)->first();
        if (!empty($user)) {
            return $model->where('user_id', $user->id);
        }
        return $model->where('user_id', 0);
    }


}
