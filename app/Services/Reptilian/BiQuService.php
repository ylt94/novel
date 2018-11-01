<?php

namespace App\Services\Reptilian;
use App\Services\BaseService;
use QL\QueryList;
use DB;

use App\Models\NovelDetail;
use App\Models\NovelBase;
use App\Models\NovelContent;

class BiQuService extends BaseService{

    /**
     * 获取小说章节url
     */
    public static function novelChaptersUrl($novel_id){

        $novel = NovelBase::find($novel_id);
        if(!$novel){
            static::addError('小说不存在',2007);
            return false;
        }
        $url = $novel->biqu_url;
        if($url){
            return $url;
        }

        $novel_name = $novel->title;
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
        $novel->biqu_url = $url;
        $novel->save(); 
        return $url;
    }

    /**
     * 获取笔趣阁所有小说章节
     */
    public static function novelChapters($url){
        $rules = [
            'title' => array('dd>a','text'),
            'href' => array('dd>a','href')
        ];
        //$html = mb_convert_encoding(file_get_contents($url),'UTF-8','GBK');

        //$ql = QueryList::html($html)->rules($rules)->query()->getData();
        $ql = QueryList::rules($rules);
        $result = $ql->get($url)
                    //->encoding('UTF-8','GBK')
                    ->query()
                    ->getData();
        $data = array();
        foreach ( dataYieldRange($result) as $item) {
            $value = array();
            $value['title'] = mb_convert_encoding($item['title'],'UTF-8','GBK');
            $value['href'] = 'http://www.biquge.com.tw'.$item['href'];
            array_push($data,$value);
        }
        return $data;
    }

    /**
     * 更新小说章节内容
     */
    public static function updateChapters($chapters){
        foreach(dataYieldRange($chapters) as $item){
            $insert_data['capter_id'] = $item['id'];
            $insert_data['content'] = self::getChapterContent($item['href']);
            if(!$insert_data['content']){
                $error = '小说章节:'.$item['id'].'更新失败:没有抓取到具体内容';
                my_log($error,'logs/capter/qidian','error');
                continue;
            }
            if($insert_data['content']){
                try{
                    DB::beginTransaction();
                    NovelContent::create($insert_data);
                    NovelDetail::where('id',$item['id'])->update(['is_update'=>1]);
                    DB::commit();
                }catch(\Exception $e){
                    DB::rollback();
                    $error = '小说章节:'.$item['id'].'更新失败:'.$e->getMessage();
                    my_log($error,'logs/capter/biqu','error');
                    return false;
                }
                
            }
        }
        return true;
    }

    /**
     * 获取章节内容
     */
    public static function getChapterContent($url){
        $rules = [
            'content' => array('#content','html'),
        ];

        $ql = QueryList::rules($rules);
        $result = $ql->get($url)
                    ->query()
                    ->getData();
        $result = mb_convert_encoding($result[0]['content'],'UTF-8','GBK');
        if(!$result){
            return false;
        }

        return $result;
    }
}