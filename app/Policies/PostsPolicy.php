<?php
namespace App\Policies;

use App\Models\Admin\User;
use App\Models\Admin\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostsPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 鉴定是否有浏览文章详情的权限
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function show(User $user,Post $post){
        if($user->name == 'admin'){
            return true;
        }
        return $user->id == $post->user_id;
    }

    /**
     * 鉴定是否有进入文章编辑页面的权限
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function edit(User $user,Post $post){
        if($user->name == 'admin'){
            return true;
        }
        return $user->id == $post->user_id;
    }

    /**
     * 鉴定是否有文章修改的权限
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function update(User $user,Post $post){
        if($user->name == 'admin'){
            return true;
        }
        return $user->id == $post->user_id;
    }

    /**
     * 鉴定是否有文章删除的权限
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function delete(User $user,Post $post){
        if($user->name == 'admin'){
            return true;
        }
        return $user->id == $post->user_id;
    }
}
