<?php


namespace App\Http\Controllers\Admin\Novel;

use App\Http\Controllers\Controller;
use DOMDocument;

class ReptilianController extends Controller{


    public function test(){

        $url = 'https://www.qidian.com/finish?action=hidden&orderId=&vip=0&style=1&pageSize=20&siteid=1&pubflag=0&hiddenField=2&page=1';
        $data = file_get_contents($url);
        //$data = htmlspecialchars($data);
        //$data = str_replace(' ','1',$data);
        // $data = str_replace('&amp','',$data);;
        // $data = str_replace('&quot','',$data);
        //var_dump($data);exit;
        $end_local = strlen($data);
        $start_local = strpos($data,'all-book-list');
        //$data = msubstr($data,0,$start_local);var_dump($data);exit;
        $data = substr($data,$start_local,$end_local);
        $end_local = strpos($data,'/ul');
        $data = substr($data,0,$end_local);//dd($data);exit;
        $data = explode('/li',$data);
        $book =array();
        foreach ($data as $item) {
            $book_item =array();
            $local = stripos($item,'</a></h4>');
            $book_name = mb_substr($item,$local-4,$local,'utf-8');dd($book_name);
            // for ($i=1;$i<=100;$i++) {
            //     $book_name = mb_substr($item,$local-1,$local);
            //     dd($book_name);
            // }
            //$book_name = substr($item,);
        }
        exit;
        $page = 1;
        do{
            $url = $url.$page;
            $res = file_get_contents($url);
        }while($result);
    }
}