<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        if(!$data['user_name'] || !$data['password'] || !$data['password_confirm']) {
            return my_view('client.error',['status'=>0,'msg'=>'请输入完完整']);
        }

        if(!$data['register_ip']){
            return my_view('client.error',['status'=>0,'msg'=>'您的ip为谜，暂时无法注册']);
        }

        if($data['password'] != $data['password_confirm']) {
            return my_view('client.error',['status'=>0,'msg'=>'两次输入的密码不一致']);
        }

        $member = MemberService::memberRegister($data);
        if(!$member) {
            return my_view('client.error',['status'=>0,'msg'=>'注册失败，请稍后再试']);
        }

        $token_res = MemberService::setLoginCache($data['register_ip'],$member->id);

        return redirect('/bookshelf');
    }

    public function login(Request $request){

        $user_name = $request->user_name;
        $password = $request->password;
        $login_ip = $request->getClientIp();
        if(!$user_name || !$password) {
            return my_view('client.error',['status'=>0,'msg'=>'请输入完完整']);
        }

        if(!$login_ip){
            return my_view('client.error',['status'=>0,'msg'=>'您的ip成谜，暂时无法登录']);
        }

        $member = MemberService::loginCheck($user_name,$password,$login_ip);
        if(is_bool($member) && !$member) {
            return my_view('client.error',['status'=>0,'msg'=>'登陆失败，请检查用户名密码']);
        }
        
        $token_res = MemberService::setLoginCache($login_ip,$member->id);
        if(!$token_res) {
            return my_view('client.error',['status'=>0,'msg'=>MemberService::getLastError()]);
        }

        return redirect('/bookshelf');
    }

    public function loginOut(Request $request){
        $login_ip = $request->getClientIp();

        MemberService::delMemberCache($login_ip);

        return redirect('/');
    }

    public function test(){
        usleep(100);
        return 'success';
    }

}