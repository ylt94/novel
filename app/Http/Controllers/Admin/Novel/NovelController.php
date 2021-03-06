<?php

namespace App\Http\Controllers\Admin\Novel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Novel\NovelService;

use App\Models\NovelBase;
use App\Models\NovelDetail;
use App\Models\NovelContent;


class NovelController extends Controller{
    

    public function getNovles(Request $request){
        $result = NovelService::novles($request);
        if(!$result) {
            return ret_res(0,2007);
        }

        return ret_res(1,1000,$result);
    }

    public function delNovel(Request $request) {
        $id = $request->id;
        if($id) {
            return ret_res(0,2006);
        }

        $result = NovelService::delNovel($id);
        if(!$result){
            return ret_res(0,2005);
        }

        return ret_res(1,1004);
    }

    public function updateNovle(Request $request){
        $id = $request->id;
        if(!$id){
            return ret_res(0,2006);
        }
        $data = $request->all();

        NovelBase::where('id',$id)->update($data);

        return ret_res(1,1002);
    }

    public function novelChapters(Request $request){
        $id = $request->id;
        $page = $request->page;
        $order_by = $request->order_by;
        if(!$id || !$page || !$order_by){
            return ret_res(0,2006);
        }

        $result = NovelService::getNovelChapters($id,$page,$order_by);
        if(!$result){
            return ret_res(0,2000);
        }

        return ret_res(1,1000,$result); 
    }

    public function updateChapters(Request $request){
        $id = $request->id;
        if(!$id){
            return ret_res(0,2006);
        }

        NovelDetail::where('id',$id)->update($request->all());

        return ret_res(1,1000); 

    }

    public function chapterContent(Request $request){
        $id = $request->id;
        if(!$id){
            return ret_res(0,2006);
        }

        $result = NovelContent::where('capter_id',$id)->first();
        if(!$result) {
            return ret_res(0,2007);
        }

        return ret_res(1,1000,$result); 
    }

    public function updateNovelContent(Request $request) {
        $id = $request->id;
        $content = $request->content;
        if(!$id){
            return ret_res(0,2006);
        }
        NovelContent::where('id',$id)->update(['content'=>$content]);

        return ret_res(1,1002);
    }
}
