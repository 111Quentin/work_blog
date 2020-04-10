<?php
namespace App\Repositories;

use App\Criteria\RoleCriteria;
use App\Model\Admin\PostLog;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Model\Admin\Post;
use App\Model\Admin\User;
use App\Http\Requests;
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
            'title' => 'like',
            'author' => 'name',
            'create_time' => 'btwtime',
        ];
    }

    public function searchName($model, $value)
    {
        $user = User::where('name', $value)->first();
        if ( !empty($user) ) {
            return $model->where('user_id', $user->id);
        }
        return $model->where('user_id', 0);
    }

    /**
     * 新增文章
     * @return bool
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function storePosts()
    {
        $user   = User::where('id', Auth::id())->first()->toArray();
        $params = array_merge(request(['title', 'desc' ,'content']), ['user_id' => Auth::id(), 'author' => $user['name'], 'created_at' => date("Y-m-d H:i:s", time())]);
        $post   = Post::create($params)->toArray();
        //入库日志
        if($post){
            $data                   =  array();
            $data['post_id']        =  $post['id'];
            $data['user_id']        =  Auth::id();
            $data['action']         =  'insert';
            $data['title']          =  request(['title'][0]);
            $data['desc']           =  request(['desc'][0]);
            $data['content']        =  request(['content'][0]);
            $data['ip']             =  $_SERVER['REMOTE_ADDR'];
            $data['create_time']    =  time();
            PostLog::insert($data);
            return true;
        }
        return false;
    }

    /**
     * 修改文章
     * @return bool
     */
    public function updatePost($post)
    {
        //获取登录用户信息
        $user   = User::where('id', Auth::id())->first()->toArray();
        $params = array_merge(request(['title', 'desc', 'content']), ['user_id' => Auth::id(), 'author' => $user['name'], 'updated_at' => date("Y-m-d H:i:s", time())]);
        $res    = $post->update($params);
        //写入日志
        if($res){
            $data                       = array();
            $data['post_id']            = $post['id'];
            $data['user_id']            = Auth::id();
            $data['action']             = 'update';
            $data['title']              = request(['title'][0]);
            $data['desc']               = request(['desc'][0]);
            $data['content']            = request(['content'][0]);
            $data['ip']                 = $_SERVER['REMOTE_ADDR'];
            $data['create_time']        = time();
            PostLog::insert($data);
            return true;
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
        $data                =      array();
        $data['post_id']     =      $id;
        $data['user_id']     =      Auth::id();
        $data['action']      =      'delete';
        $data['title']       =      $post['title'];
        $data['desc']        =      $post['desc'];
        $data['content']     =      $post['content'];
        $data['ip']          =      $_SERVER['REMOTE_ADDR'];
        $data['create_time'] =      time();
        PostLog::insert($data);
        if(self::destroy($id))
            return true;
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

}
