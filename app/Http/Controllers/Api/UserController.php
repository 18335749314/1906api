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
}
