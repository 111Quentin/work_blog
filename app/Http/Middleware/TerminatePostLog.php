<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Admin\PostLog;

class TerminatePostLog
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
     * @param \Illuminate\Http\Request $request
     * @param $response
     * @return mixed
     */
    public function terminate($request, $response)
    {
        $data = array(
            'post_id'       =>  $request->get('post_id'),
            'user_id'       =>  $request->user()->id,
            'action'        =>  $request->get('action'),
            'content'       =>  $request->get('content')? : '',
            'title'         =>  $request->get('title')? : '',
            'desc'          =>  $request->get('desc')? : '',
            'ip'            =>  $request->getClientIp(),
            'create_time'   =>  time()
        );
//        dd($data);
        return PostLog::create($data);
    }
}
