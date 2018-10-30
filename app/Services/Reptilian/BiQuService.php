<?php

namespace App\Services\Reptilian;
use App\Services\BaseService;
use QL\QueryList;

class BiQuService extends BaseService{

    /**
     * 获取跳转URL
     */
    public static function getResultUrl($html){
        if(!$html){
            return false;
        }
        print_r($html);exit;
        $ql = QueryList::html($html);
        $url = $ql->find('a')->href;dd($url);
        if(!$url){
            return false;
        }
        return $url;
    }
}