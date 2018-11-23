<?php
    namespace App\Services\Reptilian;
    
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Log;
    use QL\QueryList;

    use App\Models\NovelDetail;
    use App\Models\NovelBase;

    use App\Services\BaseService;
    use App\Services\PublicService as PS;

    class PublicService extends BaseService{

        //querylist获取信息
        public static function getDataFromQueryList($url,$rules,$use_agent = false,$type = 'get',$params = []){
            if(!$url || !$rules){
                return false;
            }
            $http = [];
            if($use_agent){
                $agent = self::getFreeIp();
                $agent_url = strtolower($agent['agent_type']).'://'.$agent['agent_ip'].':'.$agent['agent_port'];
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
            $ql = QueryList::rules($rules);
            $data = $ql->$type($url)->query()->getData();
            $ql->destruct();
            return $data;
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
            
            // $agent_type = Cache::get('agent_type');
            // $agent_ip = Cache::get('agent_ip');
            // $agent_port = Cache::get('agent_port');
            // if($agent_type && $agent_ip && $agent_port){
            //     return ['agent_type' => $agent_type,'agent_ip' => $agent_ip ,'agent_port' => $agent_port];
            // }

            
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