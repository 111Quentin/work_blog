<?php
    namespace  App\Models\Admin;
    use Illuminate\Database\Eloquent\Model;

    class LoginLog extends  Model {
        /**
         * @var string
         */
        protected $table = 'login_log';

        /**
         * @var array
         */
        protected $fillable= [
           'email', 'login_type','ip','create_time'
        ];

        public $timestamps = false;
    }