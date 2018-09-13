<?php
    namespace App\Services;

    use Illuminate\Support\Facades\Redis;

    use App\Services\BaseService;

    class RedisService extends BaseService{
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
            $key = 'member_login_'.$user->id.mt_rand(0,9999).time();
            $key = md5($key);
            if(!$key){
                static::addError('登陆失败',0);
                return false;
            }
            $data = [
                'user_id' => $user->id,
                'user_name' => $user->user_name,
            ];
            $redis_res = self::$redis->set($key,$data);
            if(!$redis_res) {
                static::addError('登陆失败',0);
                return false;
            }

            return $key;
        }

        public static function delMemberToken($key){
            $keys = self::$redis->keys($key);

            $del_res = self::$redis->del($keys);
            if(!$del_res){
                static::addError('服务器异常，请稍后再试',0);
                return false;
            }

            return true;
        }
    }