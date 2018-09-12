<?php
    namespace App\Services;

    use Illuminate\Support\Facades\Redis;

    class RedisService {
        private static $redis = null;


        public function __construct(){
            self::$redis = Redis::connection();
        }

        //设置要更新的小说ID
        public static function setNovelId($id){

            $key = 'novel_ids';
            self::$redis->lpush($key,$id);

            return true;
        }

        //获取小说ID
        public static function getNovelId(){
            $key = 'novel_ids';

            return self::$redis->lrange($key);
        }


        //设置detail
        public static function setNovelDetailId($id){
            $key = 'novel_detail_ids';

            self::$redis->lpush($key,$id);
        }

        //获取详情ID
        public static function getNovelDetailId(){
            $key = 'novel_detail_ids';

            return self::$redis->lrange($key);
        }


        public static function setMemberToken($user){
            $key = 'member_login_'.$user->id;
            $key_header = '&mermber&%';
            $key_body = mt_rand(0,9999).time().'&';
            $token = md5($key_header.$key_body);
            if(!$token){
                return false;
            }
            $data = [
                'user_id' => $user->id,
                'user_name' => $user->user_name,
                'token' => $token
            ];
            $redis_res = self::$redis->set($key,$data);
            if(!$redis_res) {
                return false;
            }

            return $value;
        }
    }