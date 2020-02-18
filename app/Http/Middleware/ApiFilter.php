<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class ApiFilter
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
        $uri = $_SERVER['REQUEST_URI'];
        $ua  = $_SERVER['HTTP_USER_AGENT'];
        
        $md5_ua = substr(md5($ua),5,8);
        $md5_uri = substr(md5($uri),5,8);

        $key = 'count:uri:'.$md5_uri.':'.$md5_ua;
        echo $key;echo "<br>";

        $count = Redis::get($key);
        echo "当前访问次数: ".$count;echo "<br>";
        $max = env('API_ACCESS_COUNT');

        if($count>$max){
            echo "你是来搞笑的吧";

            //设置超时时间
            Redis::expire($key,env('API_ITMEOUT_SECOND'));
            die;
        }

        Redis::incr($key);

        return $next($request);
    }
}
