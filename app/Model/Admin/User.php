<?php
    namespace  App\Model\Admin;
    use Illuminate\Database\Eloquent\Model;
    class User extends  Model{
        // 指定与当前模块关联的数据表
        protected $table = 'users';

        public $timestamps = true;
        // 填充字段
        protected $fillable= [
            'name', 'email', 'password','ip'
        ];
        protected $hidden = [
            'password', 'remember_token',
        ];
    }