<?php

namespace App\Services\Reptilian;
use App\Services\BaseService;
use QL\QueryList;

class BiQuService extends BaseService{

    /**
     * 获取小说章节url
     */
    public static function novelChaptersUrl($novel_name){
        $novel_name = '飞剑问道';
        $code_name = urlencode(mb_convert_encoding(' '.$novel_name,'gbk','utf-8'));
        $url = 'http://www.biquge.com.tw/modules/article/soshu.php?searchkey='.$code_name;
        
        //$agent_ip = PublicService::getAgentIp();
        //$agent_url = $agent_ip->http_type.'://'.$agent_ip->ip.':'.$agent_ip->port;
        // $header = array(
        //     'CLIENT-IP:'.$agent_ip->ip,
        //     'X-FORWARDED-FOR:'.$agent_ip->ip,
        // );
        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$url);
        //curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        // curl_setopt($ch,CURLOPT_PROXY,$agent_ip->ip);
        // curl_setopt($ch,CURLOPT_PROXYPORT,$agent_ip->port);
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3554.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $result = curl_exec($ch);
        $content = curl_getinfo($ch);
        curl_close($ch);
        $url = isset($content['redirect_url']) ? $content['redirect_url'] : '';
        if(!$url){
            return false;
        }
        return $url;
    }
}