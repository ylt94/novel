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
}