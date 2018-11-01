<?php
    namespace App\Services\Reptilian;
    
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Log;
    use QL\QueryList;

    use App\Models\NovelDetail;
    use App\Models\NovelBase;

    use App\Services\BaseService;

    class PublicService extends BaseService{


        //组装小说基础信息
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

        //小说基础信息创建
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

        //获取未更新小说章节
        public static function getUnContentCapters($site_id = 1){
            $search = array(
                'is_update' => 0,
                'site_resource' => $site_id
            );
            return NovelDetail::where($search)->orderBy('created_at','asc')->get();
        }

        //querylist获取信息
        public static function getDataFromQueryList(){

        }

        //二次处理网页信息
        public static function getDataFromHtml(){

        }

        //获取网络空闲代理Ip//http://www.goubanjia.com/
        public static function getFreeIp(){
            
            // $agent_http_type = Cache::get('agent_http_type');
            // $agent_ip = Cache::get('agent_ip');
            // $agent_port = Cache::get('agent_port');
            // if($agent_http_type && $agent_ip && $agent_port){
            //     return ['http_type' => $agent_http_type,'agent_ip' => $agent_ip ,'agent_port' => $agent_port];
            // }


            $resuorce_url = 'http://www.goubanjia.com';
            
            //$html = QueryList::rules([])->get($resuorce_url);
            // $tr = $html->query()->find('table')->find('tr:gt(0)');
            // $ip_ports = $tr->map(function($row){
            //                 return $row->find('td.ip>[style != display: none;],span:last')->texts()->all();
            //             });
            // $other_data = $tr->map(function($row){
            //     return $row->find('td')->texts()->all();
            // });
            $rules = [
                'ip' => ''
            ];
            $urls = array();
            foreach($ip_ports as $item){
                $ip_port = [];
                $url = '';
                foreach($item as $key => $val){
                    if(!$val){
                        continue;
                    }
                    if(count($item) == ($key+1)){
                        //$url .= ':'.$val;
                        $ip_port['ip'] = $url;
                        $ip_port['port'] = $val;
                        continue;
                    }
                    $url .=  $val;
                }
                array_push($urls,$ip_port);
                
            }
            $data = array();
            foreach( $other_data as $key => $item){
                $item[0] = $urls[$key]['ip'];
                array_push($item,$urls[$key]['port']);
                array_push($data,$item);
            };dd($data);
            $times = array_column($data, 5);
            array_multisort($times,SORT_ASC,$data);
            foreach($data as $item){
                preg_match('/中国/',$item[3],$check_address);
                if($check_address){
                    $agent = $item;print_r($item);
                    break;
                }
            }
            
            $agent_http_type = $agent[2];
            $agent_ip = $agent[0];
            $agent_port = $agent[8];
            Cache::put('agent_ip',$agent_ip,30);
            Cache::put('agent_port',$agent_port,30);
            Cache::put('agent_http_type',$agent_http_type,30);

            return ['http_type' => $agent_http_type,'agent_ip' => $agent_ip ,'agent_port' => $agent_port];
            
        }

        /**
         * 对比章节获取未更新章节
         * @param  $site_chapters抓取的章节
         * @param $my_chapters 本站w未更新章节
         * */
        public static function checkChapters($site_chapters,$my_chapters){
            foreach($my_chapters as &$item){
                foreach(dataYieldRange($site_chapters) as $value){
                    if($item['title'] == $value['title']){
                        $item['biqu_url'] = $value['href'];
                    }
                }
            }
            return $my_chapters;
        }
    }