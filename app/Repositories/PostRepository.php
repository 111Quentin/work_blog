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

    public function getSearchable()
    {
        return [
            'title'             => 'like',
            'author'         => 'name',
            'create_time' => 'btwtime',
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

    /**
     * 新增文章
     * @return bool
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function storePosts($request)
    {
        $user       = User::where('id', Auth::id())->first()->toArray();
        $params  = array_merge(request(['title', 'desc' ,'content']), ['user_id' => Auth::id(), 'author' => $user['name'], 'created_at' => date("Y-m-d H:i:s", time())]);
        $post       = Post::create($params)->toArray();
        if ($post) {
            $this->postLogArr($post['id'], Auth::id(), 'insert',  $request);
        } else {
            return false;
        }
    }

    /**
     * 修改文章
     * @return bool
     */
    public function updatePost($post, $request)
    {
        //获取登录用户信息
        $user          = User::where('id', Auth::id())->first()->toArray();
        $params     = array_merge(request(['title', 'desc', 'content']), ['user_id' => Auth::id(), 'author' => $user['name'], 'updated_at' => date("Y-m-d H:i:s", time())]);
        $res            = $post->update($params);
        //写入日志
        if($res) {
            $this->postLogArr($post['id'], Auth::id(), 'update', $request);
        }
        return false;
    }

    /**
     * 删除文章
     * @param $id
     * @param $post
     * @return bool
     */
    public  function  postDel($id, $post)
    {
        $this->postLogArr($id, Auth::id(), 'delete',  $post);
        if (self::destroy($id)) {
            return true;
        }
        return false;
    }

    /**
     * 文章搜索
     */
    public function postSearch($query)
    {
        if (preg_match('/\d+/', $query)) {
            $posts = Post::where('created_at', 'like', '%' . $query . '%')->paginate(10);
        } else {
            $posts = Post::where('title', 'like', '%' . $query . '%')->orWhere('author', 'like' , '%' . $query . '%')->paginate(10);
        }
        return $posts;
    }

    /**
     * PostLog字段
     */
    public function postLogArr($postId,$authID,$action,$request)
    {
        $data                        =  array();
        $data['post_id']         =  $postId;
        $data['user_id']         =  $authID;
        $data['action']           =  $action;
        $data['title']               =  $request->title;
        $data['desc']              =  $request->desc;
        $data['content']          =  $request->content;
        $data['ip']                   =  $_SERVER['REMOTE_ADDR'];
        $data['create_time']    =  time();
        if (PostLog::insert($data)) {
            return true;
        } else {
            return false;
        }
    }

}
