<?php


namespace App\Http\Controllers\Admin\Novel;

use App\Http\Controllers\Controller;
use App\Service\Reptilian\QiDianService;

class ReptilianController extends Controller{


    public function getQiDianNovels(){
        $base_url = 'https://www.qidian.com/finish?action=hidden&orderId=&vip=0&style=1&pageSize=20&siteid=1&pubflag=0&hiddenField=2&page=';
        $page = 1;
        $novel = array();
        do{
            $url = $base_url.$page;
            $result = file_get_contents($url);
            $novel = QiDianService::getTitleId($novel,$result,$page);
            if(!$novel){
                continue;
            }
            $novel = QiDianService::getAuthor($novel,$result,$page);
            $novel = QiDianService::getNovelType($novel,$result,$page);
            //$novel = QiDianService::getNovelDesc($novel,$result,$page);
            $page++;
        }while($result);
        
    }

    public function getQiDianNovelDetail(){
        $csrf_token = QiDianService::getCsrfToken();
        $novel_id = 1005064061;
        //https://book.qidian.com/ajax/book/category?_csrfToken=YcqOui8MNn3esPNxbh4wjlXTEGmz7rpNWKpkjQ1i&bookId=1005064061
        $url = 'https://book.qidian.com/ajax/book/category?'.http_build_query(['_csrfToken'=>$csrf_token,'bookId'=>$novel_id]);
        $contents = file_get_contents($url);
        dd(json_decode($contents,true));
        // // if(!$contents){
        // //     return ['status'=>-1,'msg'=>'查无此书'];
        // // }

        // //$description = QiDianService::getNovelDesc($novel_id,$contents);
        // $url = $url.'#Catalog';
        // $url = 'https://book.qidian.com/ajax/book/category?_csrfToken=yGXbCbOp8JSztmdRaqXhqy3xoEq94Lpu7IJxbSvE&bookId=1005064061';
        // $url = 'https://www.qidian.com/ajax/Free/getSysTime?_csrfToken=';
        // $contents = file_get_contents($url);dd($contents);
        // $chapters = QiDianService::getNovelChapters($novel_id,$contents);
       

    }
    
}