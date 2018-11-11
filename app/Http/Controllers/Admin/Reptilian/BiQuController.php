<?php
namespace App\Http\Controllers\Admin\Reptilian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\services\Reptilian\PublicService;
use App\Services\Reptilian\BiQuService;
use App\Services\Novel\NovelService;
use App\Models\NovelContent;
use App\Models\NovelDetail;
use App\Services\RedisService;

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
        $result = BiQuService::updateChaptersContent($chapter_result);


    }


    public function test(){
        $search = [
            'novel_id' => 183,
            'is_update' => 0
        ];
        $novel_detail_ids = NovelDetail::where($search)->orderBy('id','asc')->pluck('id')->all();
        if(!$novel_detail_ids){
            return true;
        }

        foreach($novel_detail_ids as $val){
            RedisService::setNovelDetailId($val);
        }
        return true;
        // set_time_limit(0);
        // while(true){
        //     $detail_id = RedisService::getNovelDetailId();
        //     if(!$detail_id){
        //         echo 1;
        //         break;
        //     }
        //     BiQuService::updateChapterContent($detail_id);

        //    echo 1;
        // }
    }

}