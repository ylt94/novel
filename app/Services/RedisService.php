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
    }