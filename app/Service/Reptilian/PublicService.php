<?php
    namespace App\Service\Reptilian;
    
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Log;

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
                $error = $site->name.'，小说基础信息搬运：'.$e->getMessage();
                Log::error($error,storagepath('logs/reptilian/'.$site->name));
            }
        }
    }