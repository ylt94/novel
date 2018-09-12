<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Member;

use App\Services\Member\MemberService;
use App\Services\RedisService;


class LoginController extends Controller{

    public function register(Request $request){
        $data['user_name'] = $request->user_name;
        $data['password'] = $request->password;
        $data['password_confirm'] = $request->password_confirm;
        $data['register_ip'] = $request->getClientIp();

        if(!$data['user_name'] || !$data['password'] || !$data['password_confirm'] || !$data['register_ip']) {
            return ['status'=>0,'msg'=>'请输入完整'];
        }

        if($data['password'] == $data['password_confirm']) {
            return ['status'=>0,'msg'=>'两次密码不一致'];
        }

        $result = MemberService::memberRegister($data);
        if(!$result) {
            return ['status'=>0,'msg'=>'注册失败，请稍后再试'];
        }

        return ['status'=>1,'msg'=>'注册成功'];
    }

    public function login(Request $request){
        $user_name = $request->user_name;
        $password = $request->password;
        $login_ip = $request->getClientIp();
        if(!$user_name || !$password) {
            return ['status'=>0,'msg'=>'请输入完整'];
        }

        $result = MemberService::loginCheck($user_name,$password,$login_ip);
        if(is_bool($result) && !$result) {
            return ['status'=>0,'msg'=>'登陆失败，请检查用户名密码'];
        }

        $token_res = RedisService::setMemberToken($result);
        if(!$token_res) {
            return ['status'=>0,'msg'=>'登陆失败，请骚后再试'];
        }

        return ['status'=>1,'msg'=>'登陆成功','data'=>['token'=>$token_res]];
    }
}