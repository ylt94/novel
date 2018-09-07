<?php
    namespace App\Service\Reptilian;
    
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Log;

    use App\Models\NovelDetail;

    use App\Models\NovelBase;

    class PublicService {



        public static function  careteNovelBase($data,$site,$type_config){
            $types =  array();
            foreach($type_config as $item) {
                $types[$item->id] = $item->name;
            }
            foreach($data as &$item) {
                $item['status'] = $item['status'] == '连载中' ? 1 : 2;
                $item['is_hide'] = 0;
                $item['site_source'] = $site->id;
                $item['type'] = array_search($item['type'],$types);
                $item['updated_at'] = $item['created_at'] = date('Y-m-d H:i:s',time());
            }
            unset($item);
            return $data;
        }

        public static function insertNovelBase($data,$page) {
            try{
                DB::beginTransaction();
                NovelBase::insert($data);
                DB::commit();
            }catch(\Exception $e){
                Log::useDailyFiles(storage_path('logs/reptilian/'.$site->id));
                $error = $site->name.'，小说基础信息搬运第'.$page.'页：'.$e->getMessage();
                Log::error($error);
            }
        }

        public static function getUnContentCapter($site_id = 1){
            $search = array(
                'is_content' => 0,
                'site_resource' => $site_id
            );
            return NovelDetail::where($search)->get();
        }
    }