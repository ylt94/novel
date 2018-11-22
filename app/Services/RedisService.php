<?php
    namespace App\Services;

    use Illuminate\Support\Facades\Redis;

    use App\Services\BaseService;

    class RedisService extends BaseService{
        private static $novel_base_key = 'novel_ids';
        private static $novel_detail_key = 'novel_detail_ids';

        //设置要更新的小说ID
        public static function setNovelId($id){
            Redis::lpush(self::$novel_base_key,$id);

            return true;
        }

        //获取小说ID
        public static function getNovelId(){
            return Redis::rpop(self::$novel_base_key);
        }


        //设置detail
        public static function setNovelDetailId($id){
            $key = self::$novel_detail_key;

            Redis::lpush($key,$id);
        }

        //获取详情ID
        public static function getNovelDetailId(){
            $key = self::$novel_detail_key;

            return Redis::lpop($key);
        }


        public static function setMemberToken($user){
            $key_type = 'member_login_';
            $key = $user->id.mt_rand(0,9999).time();
            $key = md5($key);
            if(!$key){
                static::addError('登陆失败',0);
                return false;
            }
            $key = $key_type.$key;
            $data = [
                'user_id' => $user->id,
                'user_name' => $user->user_name,
            ];
            $redis_res = Redis::set($key,$data);
            if(!$redis_res) {
                static::addError('登陆失败',0);
                return false;
            }

            return $key;
        }

        public static function delMemberToken($key){
            $keys = Redis::keys($key);

            $del_res = Redis::del($keys);
            if(!$del_res){
                static::addError('服务器异常，请稍后再试',0);
                return false;
            }

            return true;
        }
    }