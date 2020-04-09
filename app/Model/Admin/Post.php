<?php
    namespace  App\Model\Admin;

    use Illuminate\Database\Eloquent\Model;
    use Auth;

    class Post extends  Model {
        // 指定与当前模块关联的数据表
        protected $table = 'posts';

        // 填充字段
        protected $fillable= [
           'title', 'desc','content', 'user_id','author','create_time'
        ];





    }