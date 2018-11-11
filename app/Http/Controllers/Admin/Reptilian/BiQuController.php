<?php
namespace App\Http\Controllers\Admin\Reptilian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\services\Reptilian\PublicService;
use App\Services\Reptilian\BiQuService;
use App\Services\Novel\NovelService;
use App\Models\NovelContent;

class BiQuController extends Controller{

    /**
     * 获取小说章节
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
        $result = BiQuService::updateChaptersContent($chapter_result);

    }


    public function test(){
        dd(BiQuService::updateDetail(183));
    }

}