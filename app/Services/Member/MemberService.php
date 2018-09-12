<?php
    namespace App\Services\Member;
    use App\Models\Member;

    class MemberService {


        public static function memberRegister($data){
            $data['last_login_ip'] = $data['register_ip'];

            $data['password'] = password_hash($data['password'],PASSWORD_BCRYPT );
            if(!$data['password']) {
                return false;
            }
            unset($data['password_confirm']);

            try{
                Member::create($data);
            }catch(\Exception $e){
                return false;
            }
            return true;
        }

        public static function loginCheck($user_name,$password,$login_ip){
            $user = Member::where('username',$user_name)->first();
            if(!$user) {
                return false;
            }

            if(!password_verify($user->password,$password)){
                return false;
            }
            
            $user->last_login_ip = $login_ip;
            $user->save();
            return $user;
        }
       
    }