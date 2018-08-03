<?php
    namespace App\Service\Reptilian;
    use Illuminate\Support\Facades\Cache;


    class QiDianService {

        //匹配小说名字,id
        public static function getTitleId(array $novel,$data,$page){
            preg_match_all('/data-bid=\"[1-9][0-9]+\">(.*?)<\/a><\/h4>/u',$data, $title_res);
            if(!$title_res) {
                return false;
            }
            foreach ($title_res[1] as $key => $title) {
                // $num = count($title_res[1]);
                // echo $num.'条数据<br/>';
                $title_array_item = array();
                $title_array_item['title'] = $title;
                preg_match_all('/[1-9][0-9]+/',$title_res[0][$key],$title_item);
                $title_array_item['title_id'] = $title_item[0][0];
                array_push($novel,$title_array_item);
            }

            return $novel;
        }


        //匹配作者
        public static function getAuthor(array $novel,$data,$page){
            $base_key = ($page-1)*20;
            preg_match_all('/data-eid=\"qd_B59\" target=\"_blank\">(.*?)<\/a>/',$data, $authorizer_res);

            foreach ($authorizer_res[1] as $key => $item) {
                $k = $base_key + $key;
                $novel[$k]['author'] = $item;
            }
            return $novel;
        }

        //匹配作品类型
        public static function getNovelType(array $novel,$data,$page){
            $base_key = ($page-1)*20;
            preg_match_all('/data-eid=\"qd_B60\">(.*?)<\/a>/',$data, $type_res);

            foreach ($type_res[1] as $key => $item) {
                $k = $base_key + $key;
                $novel[$k]['type'] = $item;
            }
            return $novel;
        }


        //匹配简介
        public static function getNovelDesc($novel_id,$content){
            preg_match_all('/<div class=\"book-intro\">(.*?)<\/div>/',$content, $desc_res);
            $description = $desc_res[1][0];
            $description = str_replace("\r",'',$description);
            $description = str_replace(' ','',$description);
          
            return $description;
        }

        public static function getNovelChapters($novel_id,$content){
            
            preg_match_all('/<div class=\"catalog-content-wrap\" id=\"j-catalogWrap\" data-l1=\"14\" style=\"display: block;\">(.*?)<\/div>/',$content, $res);
            //preg_match_all('/<li data-rid=\"[1-9][0-9]*\">(.*?)<\/li>/',$content, $res);
            dd($res);
            return $chapters;
        }

        public static function getCsrfToken(){
            $csrf_token = '';
            $csrf_token_key = 'qidian_csrf_token';
            $csrf_token = Cache::get($csrf_token_key);
            if($csrf_token){
                return $csrf_token;
            }


            $url = 'https://www.qidian.com/ajax/Help/getCode?_csrfToken=';
            $oCurl = curl_init();
            // 设置请求头, 有时候需要,有时候不用,看请求网址是否有对应的要求
            $header[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8";
            $user_agent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.75 Safari/537.36";
            curl_setopt($oCurl, CURLOPT_URL, $url);
            //curl_setopt($oCurl, CURLOPT_HTTPHEADER,$header);
            // 返回 response_header, 该选项非常重要,如果不为 true, 只会获得响应的正文
            curl_setopt($oCurl, CURLOPT_HEADER, true);
            // 是否不需要响应的正文,为了节省带宽及时间,在只需要响应头的情况下可以不要正文
            curl_setopt($oCurl, CURLOPT_NOBODY, true);
            // 使用上面定义的 ua
            //curl_setopt($oCurl, CURLOPT_USERAGENT,$user_agent);
            curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, false);    // 是否需要进行服务端的SSL证书验证
    
            // 不用 POST 方式请求, 意思就是通过 GET 请求
            curl_setopt($oCurl, CURLOPT_POST, false);
    
            $sContent = curl_exec($oCurl);
            // 获得响应结果里的：头大小
            $headerSize = curl_getinfo($oCurl, CURLINFO_HEADER_SIZE);
            // 根据头大小去获取头信息内容
            $header = substr($sContent, 0, $headerSize);
            
            curl_close($oCurl);  
            //_csrfToken=zNBHov91ewRBUkSf2DsjdezDOsSdNWNC3lkBbdKO; expires
            preg_match_all('/_csrfToken=(.*?);/',$header, $res);
            if(!$res[1]){
                return false;
            }
            $csrf_token = $res[1][0];
            Cache::put($csrf_token_key,$csrf_token,90);
            return $csrf_token;
        }
    }