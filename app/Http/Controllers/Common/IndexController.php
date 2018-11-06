<?php


namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Request;

use App\Services\Common\CommonService;


class IndexController extends Controller {


    public function index(){

        $return = [];
        $return['recommends'] = CommonService::recommend();
        $return['order_recommend'] = CommonService::orderRecommend();
        $return['order_collection'] = CommonService::orderCollection();
        $return['order_click'] = CommonService::orderClick();
        $return['order_update'] = CommonService::orderNewUpdate();
        $return['order_create'] = CommonService::orderNewCreate();


        return ['status'=>1,'msg'=>'请求成功','data'=>$return];
    }


    public function search(Request $request) {
        $words = $request->words;
        if(!$type || !$words) {
            return ['status'=>0,'msg'=>'请输入完整'];
        }
        $return = CommonService::search($words);
        return ['status'=>1,'msg'=>'请求成功','data'=>$return];
    }

    public function novelDetail($novel_id){
        
        if(!$novel_id) {
            return ['status'=>0,'msg'=>'数据异常，请稍后再试'];
        }

        $result = CommonService::novelDetail($novel_id);
        if(!$result) {
            return ['status'=>0,'msg'=>CommonService::getLastError()];
        }

        //return view();
        return my_view('client.novel',$result);

    }

    public function novelContent(Request $request){
        $chapter_id = $request->chapter_id;
        if(!$chapter_id){
            return ['status'=>0,'msg'=>'请求异常，请稍后再试'];
        }

        $result = CommonService::novelContent($chapter_id);

        return ['status'=>1,'msg'=>'请求成功','data'=>$result];
    }
}