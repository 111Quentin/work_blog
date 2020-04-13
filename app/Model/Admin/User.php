<?php

namespace  App\Model\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Auth;
Use App\Http\Requests;

class User extends  Model implements \Illuminate\Contracts\Auth\Authenticatable
{
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

    // 使用trait,相当于将整个trait代码复制过来(trait是php 5.4才有的语法,主要用于实现代码复用)
    use Authenticatable;

    /**
     * 判断是否为管理员
     * @return bool
     */
    public   function isAdmin()
    {
        return $this->name== 'admin';
    }


}
