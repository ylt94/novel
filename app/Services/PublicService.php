<?php

namespace App\Services;

use App\Services\BaseService;

class PublicService extends BaseService {


    
    
    public static function Paginate($query,$page = 1,$page_num = 10,$return_array = false){

        $query_count = clone $query;
        $count = $query_count->count();

        if(!$count){
            static::addError('暂无任何数据',-1);
            false;
        }

        $offset = ($page-1)*$page_num;
        $pages = ceil($count/$page_num);

        $data = $query->offset($offset)->limit($page_num)->get();
        if($return_array){
            $data = $data->toArray();
        }

        return ['pages'=>$pages,'data'=>$data];
    }

    public static function myLog($msg,$path,$log_type = 'info'){

        $log_types = ['info','error'];
        if (!in_array($log_type,$log_types)) {
            return false;
        }
    
        \Log::useDailyFiles(storage_path($path));
        \Log::$log_type($msg);
    }
}