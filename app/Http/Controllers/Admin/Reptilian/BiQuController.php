<?php
namespace App\Http\Controllers\Admin\Reptilian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\services\Reptilian\PublicService;

class BiQuController extends Controller{

    /**
     * 获取小说章节
     */
    public function novelChapters(Request $request){
        $novel_name = '飞剑问道';
        $code_name = urlencode(mb_convert_encoding(' '.$novel_name,'gbk','utf-8'));
        $url = 'http://www.biquge.com.tw/modules/article/soshu.php?searchkey='.$code_name;
        //$agent_ip = PublicService::getAgentIp();

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
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $content = curl_exec($ch);
        curl_close($ch);
        print_r($content);
        

    }
}