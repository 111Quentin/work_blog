<?php
    namespace  App\Model\Admin;
    use Illuminate\Database\Eloquent\Model;

    class LoginLog extends  Model {
        // 指定与当前模块关联的数据表
        protected $table = 'login_log';

        // 填充字段
        protected $fillable= [
           'email', 'login_type','ip','create_time'
        ];





    }