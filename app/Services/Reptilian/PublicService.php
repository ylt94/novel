<?php
    namespace App\Services\Reptilian;
    
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Log;
    use QL\QueryList;

    use App\Models\NovelDetail;
    use App\Models\NovelBase;
    use App\Models\AgentIp;

    use App\Services\BaseService;
    use App\Services\PublicService as PS;

    class PublicService extends BaseService{

        //querylist获取信息
        public static function getDataFromQueryList($url,$rules,$use_agent = true,$type = 'get',$params = []){
            if(!$url || !$rules){
                return false;
            }
            $http = [];
            if($use_agent){
                //$agent = self::getAgentIp();
                //$agent_url = $agent['agent_ip'].':'.$agent['agent_port'];
                $agent_url = '117.191.11.80:8080';
                $http = [
                    // 设置代理
                    'proxy' => $agent_url,//http://222.141.11.17:8118',
                    //设置超时时间，单位：秒
                    'headers' => [
                        'Referer' => 'https://www.baidu.com/',
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3554.0 Safari/537.36',
                        // 'CLIENT-IP' => $agent['agent_ip'],
                        // 'X-FORWARDED-FOR' => $agent['agent_ip']
                    ]
                ];
            }
            try{
                $ql = QueryList::rules($rules);
                $data = $ql->$type($url,[],$http)->query()->getData();
            }catch(\Exception $e){
                
                $error = $e->getMessage();
                $errorcode = self::quertListErrorHandle($error);
                $change_agent_ip_code = [503,521];
                if(in_array($errorcode,$change_agent_ip_code)){
                    self::changeAgentIp();
                }
                return ['error_msg' =>$error,'http_code' => $errorcode,'data' => false];
            }
            $ql->destruct();
            return ['http_code' => 200,'data' => $data];
        }

        /**
         * querylist 错误处理
         */
        public static function quertListErrorHandle($error_msg){
            $http_code = 0;
            $http_code = strpos($error_msg,'404') === false ? 0 : 404;
            $http_code = strpos($error_msg,'521') === false ? 0 : 521;
            $http_code = strpos($error_msg,'503') === false ? 0 : 503;
            if(!$http_code){
                return $error_msg;
            }

            return $http_code;
        }

        //二次处理网页信息
        public static function getDataFromHtml(){

        }

        /**
         * 通过curl获取网页信息
         */
        public static function getHtmlByCurl($url,$method = 'get',$use_agent = true){

            if($use_agent){
                $free_ip = PublicService::getFreeIp();
                $header = array(
                    'CLIENT-IP:'.$free_ip['agent_ip'],
                    'X-FORWARDED-FOR:'.$free_ip['agent_ip'],
                );
            }
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            if($use_agent){
                curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
                curl_setopt($ch,CURLOPT_PROXY,$free_ip['agent_ip']);
                curl_setopt($ch,CURLOPT_PROXYPORT,$free_ip['agent_port']);
            }
            
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3554.0 Safari/537.36');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    
            $result = curl_exec($ch);
            curl_close($ch);
            echo $result;exit;
        }

        //获取网络空闲代理Ip//http://www.xicidaili.com/nn/
        public static function getFreeIp(){
            
            $agent_type = Cache::get('agent_type');
            $agent_ip = Cache::get('agent_ip');
            $agent_port = Cache::get('agent_port');
            if($agent_type && $agent_ip && $agent_port){
                return ['agent_type' => $agent_type,'agent_ip' => $agent_ip ,'agent_port' => $agent_port];
            }

            
            $resuorce_url = 'http://www.xicidaili.com/nn/';
            $html = QueryList::rules([])->get($resuorce_url);
            $tr = $html->query()->find('table')->find('tr:gt(0)');
            $speed = $tr->map(function($row){
                            return $row->find('td>div[class=bar]')->attr('title');
                        });
            $other_data = $tr->map(function($row){
                return $row->find('td')->texts()->all();
            });
            $agent_key = -1;
            foreach($speed as $key => $val){
                if((float)$val < 0.5){
                    $agent_key = $key;
                    break;
                }
            }
            $agent_ip = $other_data[$agent_key][1];
            $agent_port = $other_data[$agent_key][2];
            $agent_type = $other_data[$agent_key][5];
            $time = $other_data[$agent_key][8];
            $time_last_character = mb_substr($time,-1,1);
            if($time_last_character == '天'){
                $time = mb_substr($time,0,-1);
                $time = $time*60*24;
            }else{
                $time = mb_substr($time,0,-2);
            }
            
            Cache::put('agent_ip',$agent_ip,$time);
            Cache::put('agent_port',$agent_port,$time);
            Cache::put('agent_type',$agent_type,$time);

            return ['agent_type' => $agent_type,'agent_ip' => $agent_ip ,'agent_port' => $agent_port];
            
        }

        /**
         * 获取存储的代理ip
         */
        public static function getAgentIp(){
            $agent_type = Cache::get('agent_type');
            $agent_ip = Cache::get('agent_ip');
            $agent_port = Cache::get('agent_port');
            if($agent_type && $agent_ip && $agent_port){
                return ['agent_type' => $agent_type,'agent_ip' => $agent_ip ,'agent_port' => $agent_port];
            }

            $agentip = AgentIp::where('is_available',1)->orderBy('id','asc')->first();
            if(!$agentip){
                static::addError('没有可用代理ip',-1);
                return false;
            }
            Cache::put('agent_ip_id',$agentip->id,120);
            Cache::put('agent_ip',$agentip->agent_ip,120);
            Cache::put('agent_port',$agentip->agent_port,120);
            Cache::put('agent_type',$agentip->agent_type,120);

            return ['agent_type' => $agentip->agent_type,'agent_ip' => $agentip->agent_ip ,'agent_port' => $agentip->agent_port];
        }

        /**
         * 切换其他代理ip
         */
        public static function changeAgentIp(){
            $id = Cache::get('agent_ip_id');
            AgentIp::where('id',$id)->update(['is_available' => 0]);

            Cache::forget('agent_ip');
            Cache::forget('agent_port');
            Cache::forget('agent_type');
            Cache::forget('agent_ip_id');
            
            return self::getAgentIp();
        }

        /**
         * 对比章节获取未更新章节（全部检查）
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

        /**
         * 根据最后一章已更新记录获取未更新记录
         * @param $last_updated_chapter 我方最后条已更新章节
         * @param $chapters 爬取到的所有章节
         * @return $unupdate_chapters array
         */
        public static function getUnupdateChapters($last_updated_chapter,$chapters){
            if(!$last_updated_chapter){//小说未更新过
                return $chapters;
            }
            $unupdate_chapters = [];
            $is_find = 0;
            foreach(dataYieldRange($chapters) as $item){
                if($is_find == 1){
                    array_push($unupdate_chapters,$item);
                    continue;
                }elseif($is_find > 1){
                    $error_msg = '小说id:'.$last_updated_chapter['novel_id'].'更新数据异常';
                    PS::myLog($error_msg,'logs/reptilian/biqu');
                    return false;
                }
                if($item['title'] == $last_updated_chapter['title']) {
                    $is_find ++;
                }
            }

            return $unupdate_chapters;

        }

        /**
         * 获取章节内容的中文长度
         */
        public static function getContentWords($content){
            $content = (string)$content;
            $content = str_replace('&#160;','',$content);
            $content = str_replace('<br>','',$content);
            $content = str_replace("\r\n",'',$content);
            return mb_strlen($content,'utf-8');
        }

        /**
         * 生成一个随机数
         */
        public static function createRandomNumber($min,$max){
            return rand($min,$max);
        }
    }