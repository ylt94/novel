<?php


namespace App\Http\Controllers\Admin\Novel;

use App\Http\Controllers\Controller;
use App\Service\Reptilian\QiDianService;

class ReptilianController extends Controller{


    public function getQiDianNovels(){
        //$base_url = 'https://www.qidian.com/finish?action=hidden&orderId=&vip=0&style=1&pageSize=20&siteid=1&pubflag=0&hiddenField=2&page=';
        $base_url = 'https://www.qidian.com/all?orderId=&vip=0&style=1&pageSize=20&siteid=1&pubflag=0&hiddenField=0&page=';
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
            $novel = QiDianService::getNovelWords($novel,$result,$page);
            //$novel = QiDianService::getNovelDesc($novel,$result,$page);
            $page++;
        }while($page<2);
        dd($novel);
        echo '爬取完成';
    }

    public function getQiDianNovelDetail(){
        $base_url = 'https://book.qidian.com/info/';
        $csrf_token = QiDianService::getCsrfToken().'e';
        $novel_id = 1010734492;
        $url = $base_url.$novel_id;
        $content = file_get_contents($url);
        $description = QiDianService::getNovelDesc($content);
        $chapter_url = 'https://book.qidian.com/ajax/book/category?bookId=1005064061';

        //$chapter_url = 'https://book.qidian.com/ajax/book/category?'.http_build_query(['_csrfToken'=>'','bookId'=>$novel_id]);
        $contents = file_get_contents($chapter_url);
        $chapters = json_decode($contents,true);
        dd($chapters);
    }

    public function getQiDianNovelChapterContent(){
        $base_url = 'https://read.qidian.com/chapter/';
        $chapter_id = 'ORlSeSgZ6E_MQzCecGvf7A2/tSuREBNwaBdOBDFlr9quQA2';
        $url = $base_url.$chapter_id;
        $content = file_get_contents($url);
        $result = QiDianService::getChapterContent($content);
        echo $result['content'];
        //dd($result);
    }
    
}