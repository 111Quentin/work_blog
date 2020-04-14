<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Admin\LoginLog;

class TerminateSaveLoginLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    /**
     * 使用可终止中间件记录登录日志
     * @param \Illuminate\Http\Request $request
     * @param $response
     * @return mixed
     */
    public function terminate($request, $response){
        $data = array(
            'email'             => $request->get('email'),
            'login_type'        => $request->get('login_type'),
            'ip'                => $request->getClientIp(),
            'create_time'       => time()
        );
        return LoginLog::create($data);
    }


}
