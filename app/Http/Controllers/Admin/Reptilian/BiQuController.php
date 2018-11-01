<?php
namespace App\Http\Controllers\Admin\Reptilian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\NovelBase;

use App\services\Reptilian\PublicService;
use App\Services\Reptilian\BiQuService;
use App\Services\Novel\NovelService;

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
        $url = BiQuService::novelChaptersUrl($novel_id);dd($url);
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
        dd($chapter_result);
        
        //更新章节内容
        $result = BiQuService::updateChapters($chapter_result);

    }

    public function test(){
        $chapters = PublicService::getFreeIp();
        dd($chapters);
    }

}