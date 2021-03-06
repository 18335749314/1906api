<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
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

    //发送签名
    public function md5test(){
        $key = '1906';      //发送方和接收方使用同一个key
        $str = $_GET['str'];    //代签名数据
        echo '当前签名的数据:'.$str;
        echo '<br>';
        //计算签名 原始数据+key
        $sign = md5($str.$key);
        echo '计算的签名:'.$sign;
        //http://api.1906.com/api/test/md5test?str=123
    }
    
    public function md5test1(){
        $key = '1906';
        $data = $_GET['data'];      //接收到的数据
        $sign = $_GET['sign'];      //接收到的签名
        //验签 需要与发送端使用相同的规则
        $sign2 = md5($data.$key);
        echo '接收端计算机的签名:'.$sign2;echo'<br>';
        if($sign2==$sign){
            echo '验签通过';
        }else{
            echo '验签没过';
        }
        //http://api.1906.com/api/test/md5test1?data=123&sign=d1502a49e881f75058bfb1edf0fe5d59
    }

    public function weather(){
        $city = $_GET['city'];
        $url = 'https://free-api.heweather.net/s6/weather/now?location='.$city.'&key=2c58d4cb58764b0397b2dee05dde2c0a';
        // dd($url);
        $res = file_get_contents($url);
        $arr = json_decode($res,true);
        dd($arr);
        

    }
    public function lucky(){
        if(empty($_GET['birth'])){
            echo "请输入出生日期";die;
        }
        $birth = $_GET['birth'];        //出生日期

        $res = ['大吉','大利','今晚','吃鸡'];
        echo $res[$birth%5];
        //http://api.1906.com/api/test/lucky?birth=20010811
    }

    public function encrypt(){
        $str = 'Hello Word';
        echo "原文:" .$str;echo "<br>";
        $length = strlen($str); //获取字符串长度
        echo "length:".$length;echo "<br>";
        $new_str = '';
        for($i=0;$i<$length;$i++){
            echo $str[$i].'>'.ord($str[$i]);echo "<br>";
            $code = ord($str[$i]) + 1;
            echo "编码 $str[$i]" . '>' .$code.'>'.chr($code);echo "<br>";
            $new_str .= chr($code);
        }
        echo "<br>";
        echo "密文:".$new_str;echo "<br>";
    }

    public function decrypt(){
        $data = 'Ifmmp!Xpsme';
        echo "密文:" .$data;echo "<br>";

        //解密
        $length = strlen($data);
        $str = '';
        for($i=0;$i<$length;$i++){
            echo $data[$i].'>'.ord($data[$i]);echo "<br>";
            $code = ord($data[$i]) - 1;
            echo "解码:" . $data[$i].'>'.chr($code);echo "<br>";
            $str.=chr($code);
        }
        echo "解密后数据:".$str;
    }


    public function res1(){
        $data = "Hello";
        $key = file_get_contents(storage_path('keys/pub_a.key'));

        //加密
        openssl_public_encrypt($data,$enc_data,$key);
        openssl_public_encrypt($data,$enc_str,$key);
        // var_dump($enc_data);

        //将加密数据 base64_encode()
        $send_data = base64_encode($enc_data);

        //把编码后的加密的数据发送给A
        $url = "http://api.1906.com/rsa/decrypt1?data=".urlencode($send_data);

        $response = file_get_contents($url);

        echo "收到的响应数据:".$response;echo'</br>';

        $enc_str = base64_decode($arr['data']);
        $key = file_get_get_contents(storage_path('keys/priv_b.key'));
        openssl_private_decrypt($enc_str,$dec_str,$key);
    }
    //非对称加密  使用私钥解密
    public function rsa1(){
        // echo '<hr>';
        // echo "这是API";echo "<br>";
        // echo "<pre>";print_r($_GET);"</pre>";

        //解密数据
        $base64_data = base64_decode($_GET['data']);
        $key = file_get_contents(storage_path('keys/priv_a.key'));
        openssl_private_decrypt($base64_data,$dec_str,$key);
        
        //响应数据
        $str = "that 's all right";
        $priv = file_get_contents(storage_path('keys/priv_a.key'));
        openssl_private_decrypt($str,$enc_str,$priv);
        // var_dump($dec_data);
        $data = [
            'error' => 0,
            'msg'   => 'ok',
            'data'  => base64_encode($enc_str)
        ];
        return $data;
    }




}
