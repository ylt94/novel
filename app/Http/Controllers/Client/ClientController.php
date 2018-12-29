<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Client\ClientService;
use App\Services\Novel\NovelCategoryService;


class ClientController extends Controller {


    public function index(Request $request){
        $novel_type = $request->novel_type ?: 0;
        $order_type = $request->order_type ?: 'recommend';
        $return = [];
        $return = ClientService::$order_type($novel_type);
        $types = NovelCategoryService::getCategories();
        // $return['recommends'] = ClientService::recommend();
        // $return['order_recommend'] = ClientService::orderRecommend();
        // $return['order_collection'] = ClientService::orderCollection();
        // $return['order_click'] = ClientService::orderClick();
        // $return['order_update'] = ClientService::orderNewUpdate();
        // $return['order_create'] = ClientService::orderNewCreate();
        return my_view('client.index',['novel_novel' =>$novel_type,'novels'=> $return,'types' => $types]);


        //return ['status'=>1,'msg'=>'请求成功','data'=>$return];
    }


    public function search(Request $request) {
        $words = $request->words;
        if(!$words) {
            return ['status'=>0,'msg'=>'请输入完整'];
        }
        $return = ClientService::search($words);
        if(!$return){
            return false;
        }
        return ['status'=>1,'msg'=>'请求成功','data'=>$return];
    }

    public function searchChapters($novel_id){
        if(!$novel_id) {
            return false;
        }

        $result = ClientService::searchChapters($novel_id);

        return $result;
        
    }

    public function novelDetail($novel_id){
        
        if(!$novel_id) {
            return ['status'=>0,'msg'=>'数据异常，请稍后再试'];
        }

        $result = ClientService::novelDetail($novel_id);
        if(!$result) {
            return ['status'=>0,'msg'=>ClientService::getLastError()];
        }

        //return view();
        return my_view('client.novel',$result);

    }

    public function novelChapters($novel_id){
        if(!$novel_id){
            return ['status'=>0,'msg'=>'数据异常，请稍后再试'];
        }

        $result = ClientService::novelChapters($novel_id);
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

        $result = ClientService::novelContent($ids_arr[0],$ids_arr[1]);
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

        
        $result = ClientService::nextContent($ids_arr[0],$ids_arr[1]);
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

        
        $result = ClientService::lastContent($ids_arr[0],$ids_arr[1]);
        if(!$result){
            return ['status'=>0,'msg'=>'请求异常，请稍后再试'];
        }
        return my_view('client.content',$result);
    }
}