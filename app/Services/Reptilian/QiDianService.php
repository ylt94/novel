<?php
    namespace App\Services\Reptilian;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use QL\QueryList;
    use Log;
    use App\Services\Reptilian\PublicService;
    use App\Services\Novel\NovelCategoryService;

    use App\Models\Sites;
    use App\Models\NovelBase;
    use App\Models\NovelDetail;
    use App\Models\NovelContent;

    use App\Services\BaseService;

    class QiDianService extends BaseService{

        //组装小说基础信息
        public static function  insertNovelBase($data){
            if(!$data){
                return true;
            }

            $type_config = NovelCategoryService::getCategories();
            $types =  array();
            foreach($type_config as $item) {
                $types[$item->id] = $item->name;
            }
            foreach($data as &$item) {
                $item['status'] = $item['status'] == '连载中' ? 1 : 2;
                $item['is_hide'] = 0;
                $item['site_source'] = Sites::QIDIAN;
                $item['type'] = array_search($item['type'],$types);
                $item['updated_at'] = $item['created_at'] = date('Y-m-d H:i:s',time());
            }
            unset($item);
            try{
                DB::beginTransaction();
                NovelBase::insert($data);
                DB::commit();
            }catch(\Exception $e){
                $error = $site->name.'，小说基础信息创建失败：'.$e->getMessage();
                my_log($error,'logs/reptilian/qidian','error');
                return false;
            }

            return true;
        }

        //获取起点网站信息
        public static function getQiDianData(){
            $qidian = Sites::where('name','like','%起点%')->first();
            if (!$qidian) {
                static::addError('获取网站信息失败',0);
                return false;
            }
            return $qidian;
        }

        //获取起点网站所有小说
        public static function getQiDianNovels($qidian){
            $novels = NovelBase::where('site_source',$qidian->id)->orderBy('created_at','asc')->get();

            if (!$novels) {
                static::addError('获取失败',0);
                return false;
            }

            return $novels;
        }


        //检查小说是否是最新
        public static function checkNovelChapter($id,$total_chapters) {
            $novel = NovelBase::find($id);

            if($novel->total_chapters == $total_chapters){//已最新无需更新
                static::addError('已最新无需更新',0);
                return false;
            }

            $chapters = $total_chapters - $novel->total_chapters;
            $novel->total_chapters = $total_chapters;
            $novel->save();

            return $chapters;

        }

        //合并所有章节
        public static function mergeNovelChapters($data){
            $chapters = [];
            $rule = '/([0-9])|(零|一|二|三|四|五|六|七|八|九|十|百|千|万)/';
            foreach(dataYieldRange($data) as $item) {
                foreach($item['cs'] as $chapter){
                    preg_match($rule,$chapter['cN'], $rule_res);
                    if(!$rule_res){
                        continue;
                    }
                    array_push($chapters,$chapter);
                }
            }

            return $chapters;
        }

        //更新detail表
        public static function createNovelDetail($id,$data,$site_id) {
            $create_arr = array();
            $total_words = 0;
            foreach (dataYieldRange($data) as $item) {
                $create_item = [
                    'novel_id' => $id,
                    'site_resource' => $site_id, 
                    'is_free' => $item['sS'],
                    'title' => $item['cN'],
                    'site_id' => $item['cU'],
                    'words' => $item['cnt'],
                    'is_update' => 0,
                    'create_at' => $item['uT'],
                    'created_at' => date('Y-m-d H:i:s',time()),
                    'updated_at' => date('Y-m-d H:i:s',time())
                ];
                $total_words += $item['cnt'];
                array_push($create_arr,$create_item);
            }
            NovelBase::where('id',$id)->increment('words',$total_words);
            return NovelDetail::insert($create_arr);
            
        }

        public static function getQiDianNovelContent($url,$capter_id){
            $rules = array(
                'content' => array('.read-content','html')
            );

            // $result = QueryList::rules($rules)
            //                 ->get($url)
            //                 ->query()
            //                 ->getData();
            $result = PublicService::getDataFromQueryList($url,$rules);
            
            $data = $result->all();
            $content = $data[0]['content'];
            Log::useDailyFiles(storage_path('logs/capter/qidian'));
            if(!$content){
                Log::error($error);
            }
            try{
                DB::beginTransaction();
                NovelContent::create(['content'=>$content,'capter_id'=>$capter_id]);
                NovelDetail::where('id',$capter_id)->update(['is_update'=>1]);
                DB::commit();
            }catch(\Exception $e){
                DB::rollback();
                $error = '小说章节:'.$capter_id.'更新失败:'.$e->getMessage();
                Log::error($error);
                return false;
            }
            
            return true;
        }


        public static function updateDetailByQuery(NovelBase $novel_base){
            if(!$novel_base) {
                static::addError('参数错误',0);
                return false;
            }

            $base_url = 'https://book.qidian.com/ajax/book/category?';
            $csrf_token = static::getCsrfToken();//获取ajax请求token

            $url = $base_url.http_build_query(['_csrfToken'=>$csrf_token,'bookId'=>$novel_base->novel_id]);

            $contents = file_get_contents($url);
            $result = json_decode($contents,true);
            if($result['code'] != 0 || $result['msg'] != 'suc') {
                static::addError('获取小说章节失败',0);
                return false;
            }
            
            $data = $result['data'];
            try{
                DB::beginTransAction();

                $check_res = static::checkNovelChapter($novel_base->id,$data['chapterTotalCnt']);
                if(is_bool($check_res) && !$check_res) {
                    static::addError('已最新无需更新',0);
                    return false;
                }
                
                //组合所有章节
                $chapter_array = [];
                $chapter_array = static::mergeNovelChapters($data['vs']);
                //获取需要更新章节
                $new_chapters = array_slice($chapter_array,-$check_res);
                $create_res = static::createNovelDetail($novel_base->id,$new_chapters,Sites::QIDIAN);
                DB::commit();
                return true;
            }catch(\Exception $e){
               DB::rollBack();
                //dd($e->getMessage());
                return false;
            }
        }


        public static function updateContentByQuery(NovelDetail $novel_detail){
            $base_url = 'https://read.qidian.com/chapter/';

            $url = $base_url.$novel_detail->site_id;
            static::getQiDianNovelContent($url,$novel_detail->id);
            
            return true;
        }


        /**
         * 获取起点小说novel_base信息
         * @param $url 链接路径
         * @return array
         */
        public static function getNovelBase($url){
            $rules = array(
                'novel_id' => array('.book-mid-info>h4>a','data-bid'),
                'img_url' => array('.book-img-box>a>img','src'),
                'title' => array('.book-mid-info>h4>a','text'),
                'type' => array('.author>a[data-eid=qd_B60]','text'),
                'desc' => array('.intro','text'),
                'status' => array('.author>span','text'),
                'author' => array('.book-mid-info>.author>.name[data-eid=qd_B59]','text')
            );

            $result = PublicService::getDataFromQueryList($url,$rules,false);
            return $result;
        }

        /**
         * 新书入库
         */
        public static function getNewNovels($url){
            if (!$url) {
                return false;
            }

            //爬取内容
            $result = self::getNovelBase($url);
            $msg = var_export($result,true);
            //获取小说类型
            $insert_data = [];
            foreach($result as $item){
                $search = [
                    'title' => $item['title'],
                    'author' => $item['author']
                ];
                $novel = NovelBase::where($search)->first();
                if ($novel) {
                    continue;
                }
                array_push($insert_data,$item);
            }
            $insert_res = self::insertNovelBase($insert_data);

            return $insert_res;
        }
    }