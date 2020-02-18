<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function curlPOST1(){
        
    }

    public function getUrl(){
        //协议 http https
        $scheme = $_SERVER['REQUESR_SCGEME'];

        //域名
        $host = $_SERVER['HTTP_HOST'];

        //请求URI
        $url = $_SERVER['REQUEST_URL'];

        $url = $scheme . '://' . $host . $uri;

        echo '当前URl: '.$url;echo '<hr>';
        
        echo "<pre>";print_r($_SERVER);echo"</pre>";

    }

    public function redisStrr1(){
    }



}
