<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GoodsModel;
use Illuminate\Support\Facades\Redis;

class GoodsController extends Controller
{
    public function shop(){
        $goods_id = request()->input('goods_id');       //商品id
        $goods_key = 'str:goods:info:'.$goods_id;
        echo 'redis_key: '.$goods_key;echo "<br>";

        //判断是否有缓存信息
        $cache = Redis::get($goods_key);
        
        if($cache){
            echo "有缓存:";echo "<br>";
            $goods_info = json_decode($cache,true);
            echo "<pre>";print_r($goods_info);echo "</pre>";
        }else{
            echo "无缓存:";echo "<br>";
            //求数据库中取数据,并保存到缓存中
            $goods_info = GoodsModel::where(['id'=>$goods_id])->first();
            $arr = $goods_info->toArray();

            $j_goods_info = json_encode($arr);
            Redis::set($goods_key,$j_goods_info);
            Redis::expire($goods_key,5);
            echo "<pre>";print_r($arr);echo "</pre>";
        }

        echo "goods_id:" . $goods_id;echo "<br>";
        echo "商品名: hhhhhh";echo '<hr>';
        $ua = $_SERVER['HTTP_USER_AGENT'];          //用于表示UV
        $created_at = time();
        $data=[
            'goods_id'   => $goods_id,
            'ua'   => $ua,
            'ip'   => $_SERVER['REMOTE_ADDR'],
            'created_at' => $created_at
        ];
        $res = GoodsModel::insert($data);
        $pv = GoodsModel::where(['goods_id'=>$goods_id])->count(); //计算pv   
        echo $pv;
        echo '<br>';
        $uv = GoodsModel::where(['goods_id'=>$goods_id])->distinct('ua')->count('ua');
        echo $uv;
        dd($res);



    }

    public function count1(){
         //限制次数
         $max =env('API_ACCESS_COUNT');  //接口


        //判断次数是否已到上限
        $key = 'count1';
        $number = Redis::get($key);
        echo "现有访问次数:".$number;

        //超过上限
        if($number>$max){
            $timmeout = 10;
            $timmeout = env('API_TIMEOUT_SECOND'); //10秒禁止访问
            Redis::expire($key,$timmeout);
            echo '接口访问受限,超过访问次数'.$max;
            echo '请'.$timmeout.'十秒后访问';
            die;
        }
        $count = Redis::incr($key);
        echo $count;echo "<br>";
        echo "访问正常";

    }
    public function api2(){
        $ua =$_SERVER['HTTP_USER_AGENT'];
        $u =md5($ua);
        $u =substr($u,5,5);
        echo "U:".$u;echo "<br>";

        //获取当前uri
        $uri = $_SERVER['REQUEST_URI'];
        echo "URI: ".$uri;echo "<br>";

        $md5_uri = substr(md5($uri),0,8);
        echo $md5_uri;echo "<br>";

        $key = 'count:uri:'.$u.':'.$md5_uri;
        echo 'Redis Key:'.$key;echo "<br>";
    }

    public function api3(){
        $ua =$_SERVER['HTTP_USER_AGENT'];
        $u =md5($ua);
        $u =substr($u,5,5);
        echo "U:".$u;echo "<br>";

        //获取当前uri
        $uri = $_SERVER['REQUEST_URI'];
        echo "URI: ".$uri;echo "<br>";

        $md5_uri = substr(md5($uri),0,8);
        echo $md5_uri;echo "<br>";

        $key = 'count:uri:'.$u.':'.$md5_uri;
        echo 'Redis Key:'.$key;echo "<br>";
    }










}
