<?php


namespace App\Http\Controllers\Admin\Novel;

use App\Http\Controllers\Controller;
use DOMDocument;

class ReptilianController extends Controller{


    public function test(){

        $url = 'https://www.qidian.com/finish?action=hidden&orderId=&vip=0&style=1&pageSize=20&siteid=1&pubflag=0&hiddenField=2&page=1';
        $data = file_get_contents($url);
        //data-bid="1010958280">超级五福开奖系统</a></h4>
        
        //匹配小说名字,id
        preg_match_all('/data-bid=\"[1-9][0-9]+\">(.*?)<\/a><\/h4>/u',$data, $title_res);dd($title_res);
        $title_array =array();
        foreach ($title_res[0] as $item) {
            $title_array_item = array();
            preg_match_all('/[\x{4e00}-\x{9fa5}]+/u',$item,$title_item);
            $title_array_item['title'] = $title_item[0][0];
            preg_match_all('/[1-9][0-9]+/',$item,$title_item);
            $title_array_item['title_id'] = $title_item[0][0];
            array_push($title_array,$title_array_item);
        }

        //匹配作者
        preg_match_all('/data-eid=\"qd_B59\" target=\"_blank\">[\x{4e00}-\x{9fa5}]+<\/a>/u',$data, $authorizer_res);
        foreach ($authorizer_res[0] as $key => $item) {
            preg_match_all('/[\x{4e00}-\x{9fa5}]+/u',$item, $author);
            $title_array[$key]['author'] = $author[0][0];
        }

        //匹配作品类型
        preg_match_all('/data-eid=\"qd_B60\">[\x{4e00}-\x{9fa5}]+<\/a>/u',$data, $type_res);//dd($type_res);
        foreach ($type_res[0] as $key => $item) {
            preg_match_all('/[\x{4e00}-\x{9fa5}]+/u',$item, $type);
            $title_array[$key]['type'] = $type[0][0];
        }

        
        // preg_match_all('/<p class=\"intro\">\([\s\S]*\)<\/p>/',$data, $desc_res);dd($desc_res);
        // foreach ($desc_res[0] as $key => $item) {
        //     preg_match_all('/[\x{4e00}-\x{9fa5}]+/u',$item, $desc);
        //     $title_array[$key]['desc'] = $desc[0][0];
        // }
        dd($title_array);
        // //$data = htmlspecialchars($data);
        // //$data = str_replace(' ','1',$data);
        // // $data = str_replace('&amp','',$data);;
        // // $data = str_replace('&quot','',$data);
        // //var_dump($data);exit;
        // $end_local = strlen($data);
        // $start_local = strpos($data,'all-book-list');
        // //$data = msubstr($data,0,$start_local);var_dump($data);exit;
        // $data = substr($data,$start_local,$end_local);
        // $end_local = strpos($data,'/ul');
        // $data = substr($data,0,$end_local);//dd($data);exit;
        // $data = explode('/li',$data);
        // $book =array();
        // foreach ($data as $item) {
        //     $book_item =array();
        //     $local = stripos($item,'</a></h4>');
        //     $book_name = mb_substr($item,$local-4,$local,'utf-8');dd($book_name);
        //     // for ($i=1;$i<=100;$i++) {
        //     //     $book_name = mb_substr($item,$local-1,$local);
        //     //     dd($book_name);
        //     // }
        //     //$book_name = substr($item,);
        // }
        exit;
        $page = 1;
        do{
            $url = $url.$page;
            $res = file_get_contents($url);
        }while($result);
    }
}