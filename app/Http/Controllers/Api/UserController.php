<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;

class UserController extends Controller
{
    public function info(){
        $userInfo = [
            'name'  => 'zhangsan',
            'age'   =>  22,
            'sex'   => 'nan',
            'time'  => date('Y-m-d H:i:s')
        ];
        return $userInfo;
    }
    public function reg(){
        $user_info = [
            'user_name'  => \request()->input('user_name'),
            'email'  => \request()->input('email'),
            'pass'  => 123456
        ];
        $id = UserModel::insert($user_info);
        echo $id;
    }

    //access_token接口连接
    public function Access_Token(){
        $appID = 'wx622798c5aeda6e33';
        $appsecret = '5ecbfcb35df83b054700426cca9a2dda';
        $url =' https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appID.'&secret='.$appsecret.'';
        echo $url;
        echo  "<br>";
        //使用file_get_contents 发起GET请求
        $response = file_get_contents($url);
        var_dump($response);echo "<hr>";
        $arr = json_decode($response,true);
        echo "<pre>";print_r($arr);echo "</pre>";
    }

    public function curl1(){
        $appID = 'wx622798c5aeda6e33';
        $appsecret = '5ecbfcb35df83b054700426cca9a2dda';
        $url =' https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appID.'&secret='.$appsecret.'';
        echo $url;
        
        //初始化	
            curl_init($url);
        //设置参数选项
            curl_setopt($ch,CURLOPT_HEADER,0);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //执行会话
            // curl_exec($ch);
            $response=curl_exec($ch);
            
        //捕获错误
            $errno=curl_errno($ch);
            $error=curl_errno($sh);
            if($errno>0){
                echo "错误码:".$errno;echo "<br>";
                echo "错误信息:".$error;die;     
            }
        //关闭会话
        curl_close($ch);

        //  echo "服务器响应的数据：";echo "<br>";
        //  echo $response;echo '<hr>';

        //  $arr=json_decode($response,true);
        //  echo "<pre>";print_r($arr);echo "</pre>";

        //处理逻辑
        var_dump($response);
        

    }
    public function guzzle1(){
        $appID = 'wx622798c5aeda6e33';
        $appsecret = '5ecbfcb35df83b054700426cca9a2dda';
        $url =' https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appID.'&secret='.$appsecret.'';
        
        $client = new Client();
        $response = $client->request('GET',$url);
        dd($response);
    }

    //curl post 请求
    public function curl2(){
        $access_token='30_CEgHGxMeDeEbJBEH-L94CaZmmNGT-iAEgsPUmAEmCfskZIkhQQU7CdXCtncrU3TDSbIXkE8bZyM0Tv0R1NUvT5VlG9cwBNc5f3pjwZ4NlIbdPQRn-jygzr9NmygVBYdAJAJPM';
        $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token;

        $menu=[
            "button" => [
                [
                    "type"=>"click",
                    "name"=>"CURL",
                    "key"=>"curl001"
                ]
            ]
        ];

        //初始化
        $ch=curl_init($url);

        //设置参数
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //POST请求
        curl_setopt($ch,CURLOPT_POST,true);
        //发送json数据 form-data形式
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
        curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($menu));

        //执行curl会话
        $response=curl_exec($ch);

        //获取错误
        $errno=curl_errno($ch);
        $error=curl_error($ch);
        if($errno>0) //有问题
        {
            echo "错误码：".$errno;echo "<br>";
            echo "错误信息：".$error;die;
            die;
        }

        //关闭会话
        curl_close($ch);

        //数据处理
        var_dump($response);
    }

    public function guzzle2(){
        $app_id='wx0079197aeab14faf';
        $appsecret='e76097268baf9e05fed3c7d35c1430ab';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$app_id.'&secret='.$appsecret.'';
        //echo $url;

        $client=new Client();
        $response=$client->request('GET',$url);
        $data=$response->getBody();  //获取服务器响应的数据
        echo $data;
        //dd($response);
    }




}
