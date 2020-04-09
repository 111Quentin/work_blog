<?php
namespace  App\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Model\Admin\User;
use App\Http\Requests;
use App\Model\Admin\PostLog;

class Post extends  Model {
    // 指定与当前模块关联的数据表
    protected $table = 'posts';

    // 填充字段
    protected $fillable= [
       'title', 'desc','content', 'user_id','author','create_time'
    ];

    /**
     * 获取文章
     * @return mixed
     */
    public function getPosts()
    {
        $user = Auth::user()->toArray();
        if ($user['name'] == 'admin') {
            $posts = Post::where('id', '>', 0)->orderBy('created_at', 'desc')->paginate(5);
        } else {
            $posts = Post::where('user_id', $user['id'])->orderBy('created_at', 'desc')->paginate(5);
        }
        return $posts;
    }

    /**
     * 新增文章
     * @return mixed
     */
    public function storePosts()
    {
        $user   = User::where('id', Auth::id())->first()->toArray();
        $params = array_merge(request(['title', 'desc' ,'content']), ['user_id' => Auth::id(), 'author' => $user['name'], 'created_at' => date("Y-m-d H:i:s", time())]);
        $post   = self::create($params)->toArray();
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
        $res = $post->update($params);
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
    public function postDel($id, $post)
    {
        $data = array();
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
}