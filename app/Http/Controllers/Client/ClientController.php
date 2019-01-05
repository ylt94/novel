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
            return my_view('client.error',['status'=>0,'msg'=>'请输入完整']);
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

    public function novelDetail($novel_id,Request $request){

        if(!$novel_id) {
            return my_view('client.error',['status'=>0,'msg'=>'数据异常，请稍后再试']);
        }

        //获取访问ip
        $user_ip = $request->getClientIp();

        //主体信息
        $novel_base = ClientService::novelBase($novel_id);
        if(!$novel_base){
            return my_view('client.error',['status'=>0,'msg'=>ClientService::getLastError()]);
        }

        //修改点击量
        ClientService::addClickNum($user_ip,$novel_id);

        //小说字数类型
        $novel_base->words = bcdiv($novel_base->words,10000,2);
        if((int)$novel_base->type){
            $novel_type = ClientService::novelType($novel_base->type);
            $novel_base->novel_type = $novel_type ? $novel_type->name : '玄幻';
        }

        //最新章节
        $chapter = ClientService::finalChapter($novel_id);
        if(!$chapter) {
            return my_view('client.error',['status'=>0,'msg'=>ClientService::getLastError()]);
        }

        //作者其他作品
        $author_other = ClientService::authorOther($novel_base->id,$novel_base->author);


        //相关推荐
        $relevant_recommend = ClientService::relevantRecommend($novel_base->id,$novel_base->type);
        $return = [
            'novel_base' => $novel_base,
            'last_chapter' => $chapter,
            'author_other' => $author_other,
            'relevant_recommend' => $relevant_recommend
        ];


        return my_view('client.novel',$return);

    }

    public function novelChapters($novel_id){
        if(!$novel_id){
            return my_view('client.error',['status'=>0,'msg'=>'数据异常，请稍后再试']);
        }

        $novel_base = ClientService::novelBase($novel_id);
        if(!$novel_base){
            return my_view('client.error',['status'=>0,'msg'=>ClientService::getLastError()]);
        }

        $novel_chapters = ClientService::novelChapters($novel_id);
        if (!$novel_chapters) {
            return my_view('client.error',['status'=>0,'msg'=>'数据异常，请稍后再试']);
        }

        return my_view('client.chapters',['title' =>$novel_base->title,'chapters' => $novel_chapters]);
    }

    public function novelContent($ids){
        if(!$ids){
            return my_view('client.error',['status'=>0,'msg'=>'请求异常，请稍后再试']);
        }

        $ids_arr = explode('_',$ids);
        if(count($ids_arr) !=2){
            return my_view('client.error',['status'=>0,'msg'=>'请求异常，请稍后再试']);
        }

        $novel_chapter = ClientService::novelChapter($ids_arr[0],$ids_arr[1]);
        if(!$novel_chapter){
            return my_view('client.error',['status'=>0,'msg'=>ClientService::getLastError()]);
        }
        
        $content = ClientService::novelContent($ids_arr[0],$novel_chapter->id);
        if(!$content){
            if($novel_chapter->biqu_url){
                $content = ClientService::reptilianContent($novel_chapter->biqu_url);
            }else{
                return my_view('client.error',['status'=>0,'msg'=>'暂无该章节内容']);
            }
        }
        $novel = ClientService::novelBase($ids_arr[0]);

        $novel_chapter->content = $content;
        $novel_chapter->novel_title = $novel->title;
        
        return my_view('client.content',$novel_chapter);
    }

    /**
     * 下一章
     */
    public function nextContent($ids){
        if(!$ids){
            return my_view('client.error',['status'=>0,'msg'=>'请求异常，请稍后再试']);
        }

        $ids_arr = explode('_',$ids);
        if(count($ids_arr) !=2){
            return my_view('client.error',['status'=>0,'msg'=>'请求异常，请稍后再试']);
        }

        $next_chapter = ClientService::hasNextChapter($ids_arr[0],$ids_arr[1]);
        if(!$next_chapter){
            return my_view('client.error',['status'=>0,'msg'=>ClientService::getLastError()]);
        }
        
        $content = ClientService::novelContent($ids_arr[0],$next_chapter->id);
        if(!$content){
            if($next_chapter->biqu_url){
                $content = ClientService::reptilianContent($next_chapter->biqu_url);
            }else{
                return my_view('client.error',['status'=>0,'msg'=>'暂无该章节内容']);
            }
        }
        $novel = ClientService::novelBase($ids_arr[0]);

        $next_chapter->content = $content;
        $next_chapter->novel_title = $novel->title;
        
        return my_view('client.content',$next_chapter);
    }

    /**
     * 上一章
     */
    public function lastContent($ids){
        if(!$ids){
            return my_view('client.error',['status'=>0,'msg'=>'请求异常，请稍后再试']);
        }

        $ids_arr = explode('_',$ids);
        if(count($ids_arr) !=2){
            return my_view('client.error',['status'=>0,'msg'=>'请求异常，请稍后再试']);
        }

        
        $last_chpater = ClientService::hasLastChapter($ids_arr[0],$ids_arr[1]);
        if(!$last_chpater){
            return my_view('client.error',['status'=>0,'msg'=>ClientService::getLastError()]);
        }

        $content = ClientService::novelContent($ids_arr[0],$last_chpater->id);
        if(!$content){
            if($last_chpater->biqu_url){
                $content = ClientService::reptilianContent($next_chapter->biqu_url);
            }else{
                return my_view('client.error',['status'=>0,'msg'=>'暂无该章节内容']);
            }
        }
        $novel = ClientService::novelBase($ids_arr[0]);

        $last_chpater->content = $content;
        $last_chpater->novel_title = $novel->title;

        return my_view('client.content',$last_chpater);
    }
}