<?php
namespace App\Http\Controllers\Admin\Reptilian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Reptilian\PublicService;
use App\Services\Reptilian\BiQuService;
use App\Services\Novel\NovelService;
use App\Models\NovelContent;
use App\Models\NovelDetail;
use App\Services\PublicService as PS;

class BiQuController extends Controller{

    /**
     * 手动更新小说
     */
    public function novelChapters(Request $requset){
        $novel_id = $requset->novel_id;
        if(!$novel_id){
            return ret_res(0,2006);
        }
        //获取小说章节url
        $url = BiQuService::novelChaptersUrl($novel_id);
        if(!$url){
            return ret_res(0,2005);
        }
        

        //获取所有章节
        $chapters = BiQuService::novelChapters($url);
        if(!$chapters){
            return ret_res(0,2005);
        }

        //获取我方未更新的章节
        $unupdate_chapters = NovelService::unupdateChapters($novel_id,true);
        
        //对比章节查找
        $chapter_result = PublicService::checkChapters($chapters,$unupdate_chapters);
        
        //更新章节内容
        $result = BiQuService::updateChaptersContent($novel_id,$chapter_result);


    }


    public function test(Request $requset){
        $table = NovelService::ChoiceTable(232600,20,'NovelDetail\NovelDetail_');
        dd(new $table);
        //$error = 'ip:'.$requset->getClientIp();
        //PS::myLog($error,'logs/reptilian/biqu');exit;
        $rules = [
            'all'=> array('#maininfo>#info','html'),
            'type' => array('.con_top','text'),
            'desc' => array('#intro>p','text'),
            'img_url' => array('#sidebar>#fmimg>img','src'),
        ];
        dd(PublicService::getDataFromQueryList('http://www.biquge.com.tw/18_18820',$rules,false));
        BiQuService::getNovelBase('http://www.biquge.com.tw/19_19757/');
    }

}