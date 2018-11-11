<?php

namespace App\Services\Reptilian;
use App\Services\BaseService;
use QL\QueryList;
use DB;
use App\Services\Reptilian\PublicService;
use App\Services\Novel\NovelService;

use App\Models\NovelDetail;
use App\Models\NovelBase;
use App\Models\NovelContent;
use App\Models\Sites;

class BiQuService extends BaseService{
    const BIQU_BASE_URL = 'http://www.biquge.com.tw';
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

        $free_ip = PublicService::getFreeIp();
        $header = array(
            'CLIENT-IP:'.$free_ip['agent_ip'],
            'X-FORWARDED-FOR:'.$free_ip['agent_ip'],
        );

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch,CURLOPT_PROXY,$free_ip['agent_ip']);
        curl_setopt($ch,CURLOPT_PROXYPORT,$free_ip['agent_port']);
        if($free_ip['agent_type'] == 'https'){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3554.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $result = curl_exec($ch);
        $content = curl_getinfo($ch);
        curl_close($ch);
        $url = isset($content['redirect_url']) ? $content['redirect_url'] : '';
        if(!$url){
            return false;
        }
        $novel->biqu_url = rtrim($url,'/');
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
        
        $ql = QueryList::rules($rules);
        $result = $ql->get($url)
                    ->query()
                    ->getData();
        $data = array();
        foreach ( dataYieldRange($result) as $item) {
            $value = array();
            $value['title'] = mb_convert_encoding($item['title'],'UTF-8','GBK');
            $value['href'] = self::BIQU_BASE_URL.$item['href'];
            array_push($data,$value);
        }
        return $data;
    }

    /**
     * 更新小说章节内容(所有)
     */
    public static function updateChaptersContent($chapters){
        foreach(dataYieldRange($chapters) as $item){
            $insert_data['capter_id'] = $item['id'];
            if(!$item['biqu_url']){
                $msg = '章节id：'.$item['id'].'未匹配到url';
                my_log($msg,'logs/capter/biqu','error');
                continue;
            }
            $insert_data['content'] = self::getChapterContent($item['biqu_url']);
            if(!$insert_data['content']){
                $error = '小说章节:'.$item['id'].'更新失败:没有抓取到具体内容';
                my_log($error,'logs/capter/qidian','error');
                continue;
            }
            if($insert_data['content']){
                try{
                    DB::beginTransaction();
                    NovelContent::create($insert_data);
                    NovelDetail::where('id',$item['id'])->update(['is_update'=>1,'biqu_url' => $item['biqu_url']]);
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

    /**
     * 将获取到的未更新章节插入到数据库
     */
    public static function insertChapters($novel_id,$unupdate_chapters){
        if(!$novel_id) {
            return false;
        }
        if (!$unupdate_chapters) {
            return true;
        }
        $insert_data = [];
        foreach(dataYieldRange($unupdate_chapters) as $item){
            $insert_data_item = [
                'novel_id' => $novel_id,
                'title' => $item['title'],
                'site_resource' =>  Sites::BIQU,
                'biqu_url' => self::BIQU_BASE_URL.$item['href'],
                'is_update' => 0
            ];
            array_push($insert_data,$insert_data_item);
        }
        NovelDetail::insert($insert_data);
        return true;
    }

    /**
     * 更新章节
     */
    public static function updateDetail($novel_id){
        if(!$novel_id) {
            return false;
        }

        //获取url
        $biqu_url = self::novelChaptersUrl($novel_id);
        if(!$biqu_url){
            return false;
        }

        //获取url页面的所有章节信息
        $biqu_chapters = self::novelChapters($biqu_url);
        if (!$biqu_chapters) {
            return false;
        }

        //获取我方已更新章节的最后一章
        $last_updated_chapter = NovelService::lastUpdatedChapter($novel_id,true);

        //获取未更新章节
        $unupdate_chapters = PublicService::getUnupdateChapters($last_updated_chapter,$biqu_chapters);
        if (!$unupdate_chapters) {
            return false;
        }

        //将未更新章节存到数据库
        $result = self::insertChapters($novel_id,$unupdate_chapters);
        return $result;
    }

    /**
     * 更新单个章节内容
     */
    public static function updateChapterContent($chapter_id){
        if(!$chapter_id){
            return false;
        }
        $chapter = NovelDetail::find($chapter_id);
        if($chapter->is_update){
            return true;
        }

        if(!$chapter->biqu_url){
            $msg = '章节:'.$chapter_id.'笔趣内容连接采集到,无法更新章节内容';
            my_log($msg,'logs/reptilian/biqu');
            return false;
        }
        $insert_data = [
            'capter_id' => $chapter_id
        ];

        $insert_data['content'] = self::getChapterContent($chapter->biqu_url);
        if(!$insert_data['content']){
            $error = '小说章节:'.$item['id'].'更新失败:没有抓取到具体内容';
            my_log($error,'logs/capter/qidian','error');
            return false;
        }
        //获取小说字数
        $content_words = PublicService::getContentWords($insert_data['content']);
        DB::beginTransaction();
        try{
            NovelContent::create($insert_data);
            NovelDetail::where('id',$item['id'])->update([
                'is_update'=>1,
                'biqu_url' => $item['biqu_url'],
                'words' => $content_words,
            ]);
            NovelBase::where('id',$id)->increment('words',$content_words);
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            $error = '小说章节:'.$chapter_id.'更新失败:'.$e->getMessage();
            my_log($error,'logs/capter/biqu','error');
            return false;
        }
    }
}