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
        $base_url = 'https://book.qidian.com/info/';
        $novel_id = 1005064061;
        $url = $base_url.$novel_id;
        // //$contents = file_get_contents($url);

        // // if(!$contents){
        // //     return ['status'=>-1,'msg'=>'查无此书'];
        // // }

        // //$description = QiDianService::getNovelDesc($novel_id,$contents);
        // $url = $url.'#Catalog';
        // $url = 'https://book.qidian.com/ajax/book/category?_csrfToken=yGXbCbOp8JSztmdRaqXhqy3xoEq94Lpu7IJxbSvE&bookId=1005064061';
        // $url = 'https://www.qidian.com/ajax/Free/getSysTime?_csrfToken=';
        // $contents = file_get_contents($url);dd($contents);
        // $chapters = QiDianService::getNovelChapters($novel_id,$contents);
        $url = 'https://www.qidian.com/';
        $oCurl = curl_init();
        // 设置请求头, 有时候需要,有时候不用,看请求网址是否有对应的要求
        $header[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
        $user_agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.75 Safari/537.36";
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_HTTPHEADER,$header);
        // 返回 response_header, 该选项非常重要,如果不为 true, 只会获得响应的正文
        curl_setopt($oCurl, CURLOPT_HEADER, true);
        // 是否不需要响应的正文,为了节省带宽及时间,在只需要响应头的情况下可以不要正文
        curl_setopt($oCurl, CURLOPT_NOBODY, true);
        // 使用上面定义的 ua
        curl_setopt($oCurl, CURLOPT_USERAGENT,$user_agent);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );

        // 不用 POST 方式请求, 意思就是通过 GET 请求
        curl_setopt($oCurl, CURLOPT_POST, false);

        $sContent = curl_exec($oCurl);
        // 获得响应结果里的：头大小
        $headerSize = curl_getinfo($oCurl, CURLINFO_HEADER_SIZE);
        // 根据头大小去获取头信息内容
        $header = substr($sContent, 0, $headerSize);
        
        curl_close($oCurl);  
        return $headerSize; 

    }
    
}