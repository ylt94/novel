<?php
    namespace App\Service\Reptilian;


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
    }