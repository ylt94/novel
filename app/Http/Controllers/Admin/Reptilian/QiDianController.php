<?php


namespace App\Http\Controllers\Admin\Reptilian;

use App\Http\Controllers\Controller;

use App\Services\Reptilian\QiDianService;
use QL\QueryList;
use App\Services\Novel\NovelCategoryService;
use App\Services\Site\SiteService;
use App\Services\Reptilian\PublicService;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class QiDianController extends Controller{

    //public static $categories = null;
    //public static $site = null;
    
    // public function getQiDianNovels(){
    //     //$base_url = 'https://www.qidian.com/finish?action=hidden&orderId=&vip=0&style=1&pageSize=20&siteid=1&pubflag=0&hiddenField=2&page=';
    //     $base_url = 'https://www.qidian.com/all?orderId=&vip=0&style=1&pageSize=20&siteid=1&pubflag=0&hiddenField=0&page=';
    //     $page = 1;
    //     $novel = array();
    //     do{
    //         $url = $base_url.$page;
    //         $result = file_get_contents($url);
    //         $novel = QiDianService::getTitleId($novel,$result,$page);
    //         if(!$novel){
    //             continue;
    //         }
    //         $novel = QiDianService::getAuthor($novel,$result,$page);
    //         $novel = QiDianService::getNovelType($novel,$result,$page);
    //         $novel = QiDianService::getNovelWords($novel,$result,$page);
    //         //$novel = QiDianService::getNovelDesc($novel,$result,$page);
    //         $page++;
    //     }while($page<2);
    //     dd($novel);
    //     echo '爬取完成';
    // }

    // public function getQiDianNovelDetail(){
    //     $base_url = 'https://book.qidian.com/info/';
    //     $csrf_token = QiDianService::getCsrfToken();
    //     $novel_id = 1010734492;
    //     $url = $base_url.$novel_id;
    //     $content = file_get_contents($url);
    //     $description = QiDianService::getNovelDesc($content);
    //     $chapter_url = 'https://book.qidian.com/ajax/book/category?bookId=1005064061';

    //     //$chapter_url = 'https://book.qidian.com/ajax/book/category?'.http_build_query(['_csrfToken'=>'','bookId'=>$novel_id]);
    //     $contents = file_get_contents($chapter_url);
    //     $chapters = json_decode($contents,true);
    //     dd($chapters);
    // }

    // public function getQiDianNovelChapterContent(){
    //     $base_url = 'https://read.qidian.com/chapter/';
    //     $chapter_id = 'ORlSeSgZ6E_MQzCecGvf7A2/tSuREBNwaBdOBDFlr9quQA2';
    //     $url = $base_url.$chapter_id;
    //     $content = file_get_contents($url);
    //     $result = QiDianService::getChapterContent($content);
    //     echo $result['content'];
    //     //dd($result);
    // }
    

    //获取小说基本信息
    public function getNovelBase() {
        
        $categories = NovelCategoryService::getCategories();
        $site =  SiteService::getSiteByName('起点中文网');
        $rules = array(
            'novel_id' => array('.book-mid-info>h4>a','data-bid'),
            'img_url' => array('.book-img-box>a>img','src'),
            'title' => array('.book-mid-info>h4>a','text'),
            'type' => array('.author>a[data-eid=qd_B60]','text'),
            'desc' => array('.intro','text'),
            'status' => array('.author>span','text'),
            'author' => array('.book-mid-info>.author>.name[data-eid=qd_B59]','text')
        );
        $base_url = 'https://www.qidian.com/all?orderId=&style=1&pageSize=20&siteid=1&pubflag=0&hiddenField=0&page=';
        $page = 1;
        $arr = [];
        $ql = QueryList::rules($rules);
        do{
            $url = $base_url.$page;
            $data = $ql->get($url)
                    ->query()
                    ->getData();
            $data =  $data->all();
            $data = array_slice($data,0,20);
            //$data = PublicService::careteNovelBase($data,$site,$categories);
            //$result = PublicService::insertNovelBase($data,$page);
            $ql->destruct();
            $arr = array_merge($arr,$data);
            $page++;
        }while($page<2);
        dd($arr);
        echo 'success';
        
    }
    

    //获取小说章节
    public function getNovelDetail(){
        $site = QiDianService::getQiDianData();
        if(!$site) {
            exit;
        }

        $novels = QiDianService::getQiDianNovels($site);
        if (!$novels) {
            exit;
        }

        $base_url = 'https://book.qidian.com/ajax/book/category?';
        $csrf_token = QiDianService::getCsrfToken();//获取ajax请求token
        foreach ($novels as $item) {
            $url = $base_url.http_build_query(['_csrfToken'=>$csrf_token,'bookId'=>$item->novel_id]);

            $contents = file_get_contents($url);
            $result = json_decode($contents,true);
            if($result['code'] != 0 || $result['msg'] != 'suc') {
                continue;
            }
            
            $data = $result['data'];
            //try{
                //DB::beginTransAction();

                $check_res = QiDianService::checkNovelChapter($item->id,$data['chapterTotalCnt']);
                if(is_bool($check_res) && !$check_res) {
                    continue;
                }
                
                //组合所有章节
                $chapter_array = [];
                $chapter_array = QiDianService::mergeNovelChapters($data['vs']);
                //获取需要更新章节
                $new_chapters = array_slice($chapter_array,-$check_res);
                $create_res = QiDianService::createNovelDetail($item->id,$new_chapters,$site->id);
                //DB::commit();
            //}catch(\Exception $e){
               // DB::rollBack();
                //dd($e->getMessage());
            //}
            
        }

        echo 'success';

    }


    //获取小说章节内容
    public function getNovelContent(){
        $base_url = 'https://read.qidian.com/chapter/';
        $capters = PublicService::getUnContentCapters();
        foreach ($capters as $capter) {
            if(!$capter->is_free){
                continue;
            }
            $url = $base_url.$capter->site_id;
            QiDianService::getQiDianNovelContent($url,$capter->id);
        }
        echo 'success';
    }

    public function test(Request $request){
        dd($request->getClientIp());
    }
    
}