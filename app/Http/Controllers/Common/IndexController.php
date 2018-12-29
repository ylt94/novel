<?php


namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Common\CommonService;
use App\Services\Novel\NovelCategoryService;


class IndexController extends Controller {


    public function index(Request $request){
        $novel_type = $request->novel_type ?: 0;
        $order_type = $request->order_type ?: 'recommend';
        $return = [];
        $return = CommonService::$order_type($novel_type);
        $types = NovelCategoryService::getCategories();
        // $return['recommends'] = CommonService::recommend();
        // $return['order_recommend'] = CommonService::orderRecommend();
        // $return['order_collection'] = CommonService::orderCollection();
        // $return['order_click'] = CommonService::orderClick();
        // $return['order_update'] = CommonService::orderNewUpdate();
        // $return['order_create'] = CommonService::orderNewCreate();
        return my_view('client.index',['novel_novel' =>$novel_type,'novels'=> $return,'types' => $types]);


        //return ['status'=>1,'msg'=>'请求成功','data'=>$return];
    }


    public function search(Request $request) {
        $words = $request->words;
        if(!$words) {
            return ['status'=>0,'msg'=>'请输入完整'];
        }
        $return = CommonService::search($words);
        if(!$return){
            return false;
        }
        return ['status'=>1,'msg'=>'请求成功','data'=>$return];
    }

    public function searchChapters($novel_id){
        if(!$novel_id) {
            return false;
        }

        $result = CommonService::searchChapters($novel_id);

        return $result;
        
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

    public function novelChapters($novel_id){
        if(!$novel_id){
            return ['status'=>0,'msg'=>'数据异常，请稍后再试'];
        }

        $result = CommonService::novelChapters($novel_id);
        if (!$result) {
            return ['status'=>0,'msg'=>'数据异常，请稍后再试'];
        }

        return my_view('client.chapters',$result);
    }

    public function novelContent($ids){
        if(!$ids){
            return ['status'=>0,'msg'=>'请求异常，请稍后再试'];
        }

        $ids_arr = explode('_',$ids);
        if(count($ids_arr) !=2){
            return ['status'=>0,'msg'=>'请求异常，请稍后再试'];
        }

        $result = CommonService::novelContent($ids_arr[0],$ids_arr[1]);
        if(!$result){
            return ['status'=>0,'msg'=>'请求异常，请稍后再试'];
        }
        return my_view('client.content',$result);
    }

    /**
     * 下一章
     */
    public function nextContent($ids){
        if(!$ids){
            return ['status'=>0,'msg'=>'请求异常，请稍后再试'];
        }

        $ids_arr = explode('_',$ids);
        if(count($ids_arr) !=2){
            return ['status'=>0,'msg'=>'请求异常，请稍后再试'];
        }

        
        $result = CommonService::nextContent($ids_arr[0],$ids_arr[1]);
        if(!$result){
            return ['status'=>0,'msg'=>'请求异常，请稍后再试'];
        }
        return my_view('client.content',$result);
    }

    /**
     * 上一章
     */
    public function lastContent($ids){
        if(!$ids){
            return ['status'=>0,'msg'=>'请求异常，请稍后再试'];
        }

        $ids_arr = explode('_',$ids);
        if(count($ids_arr) !=2){
            return ['status'=>0,'msg'=>'请求异常，请稍后再试'];
        }

        
        $result = CommonService::lastContent($ids_arr[0],$ids_arr[1]);
        if(!$result){
            return ['status'=>0,'msg'=>'请求异常，请稍后再试'];
        }
        return my_view('client.content',$result);
    }
}