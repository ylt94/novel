<?php


namespace App\Http\Controllers\Admin\Novel;

use App\Http\Controllers\Controller;
use App\Service\Reptilian\QiDianService;

class ReptilianController extends Controller{


    public function test(){
        $base_url = 'https://www.qidian.com/finish?action=hidden&orderId=&vip=0&style=1&pageSize=20&siteid=1&pubflag=0&hiddenField=2&page=';
        $page = 1;
        $novel = array();
        do{
            $url = $base_url.$page;
            $result = file_get_contents($url);
            $novel = QiDianService::getTitleId($novel,$result,$page);
            $novel = QiDianService::getAuthor($novel,$result,$page);
            $novel = QiDianService::getNovelType($novel,$result,$page);
            $novel = QiDianService::getNovelDesc($novel,$result,$page);
            $page++;
        }while($page<=2);
        dd($novel);
    }
}