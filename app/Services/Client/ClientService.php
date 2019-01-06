<?php

namespace App\Services\Client;

use App\Models\NovelBase;
use App\Models\NovelDetail;
use App\Models\NovelCategory;
use App\Models\NovelContent;
use App\Models\Member;

use App\Services\BaseService;
use App\Services\Reptilian\BiQuService;
use App\Services\RedisService;
use App\Services\Novel\NovelService;
use Cache;


class ClientService extends BaseService{

    //搜索
    public static function search($words){
        $search = [
            'is_hide' => 0
        ];
       
        $novel_id = NovelBase::where($search)->where('title','like',$words.'%')->pluck('id')->first();
        if($novel_id){
            return self::novelDetail($novel_id);
        }else{
            $url = BiQuService::novelChaptersUrl($words);
            $novel = BiQuService::getNovelBase($url);
        }
                            
        return $novel;
    }

    //抓取章节
    public static function searchChapters($novel_id){
        $url = NovelBase::where('id',$novel_id)->pluck('biqu_url')->first();
        if(!$url){
            return false;
        }

        $biqu_chapters = BiQuService::novelChapters($url);
        if(!$biqu_chapters){
            return false;
        }

        $insert_res = BiQuService::insertChapters($novel_id,$biqu_chapters);
        if(!$insert_res){
            return false;
        }
        $result = self::novelChapters($novel_id);
        foreach(dataYieldRange($result['chapters']) as $chapter){
            $item = [
                'novel_id' => $novel_id,
                'detail_id' => $chapter['id']
            ];
            RedisService::setNovelDetailId($item);
        }
        return $result;

    }

    //推荐
    public static function recommend($novel_type){
        $search = [
            'is_hide' => 0,
            'is_recommend' => 1,
        ];
        if($novel_type){
            $search['type'] = $novel_type;
        }
        $result = NovelBase::where($search)->where('total_chapters','>',0)->select(
            'id',
            'title',
            'desc',
            'author',
            'status',
            'words',
            'img_url'
        )->orderBy('id','asc')->get();

        return $result;
        
    }

    //热门
    public static function collection($novel_type){
        $search = [
            'is_hide' => 0,
            'is_recommend' => 0,
        ];
        if($novel_type){
            $search['type'] = $novel_type;
        }
        $result = NovelBase::where($search)->select(
            'id',
            'title',
            'author',
            'desc',
            'status',
            'words',
            'img_url'
        )->orderBy('collection_num','desc')->take(15)->get();
        return $result;
    }

    //点击量
    public static function click($novel_type){
        $search = [
            'is_hide' => 0,
            'is_recommend' => 0,
        ];
        if($novel_type){
            $search['type'] = $novel_type;
        }

        $result = NovelBase::where($search)->select(
            'id',
            'title',
            'author',
            'status',
            'desc',
            'words',
            'img_url'
        )->orderBy('click_num','desc')->take(15)->get();
        return $result;
    }

    //推荐量
    public static function orderRecommend($novel_type){
        $search = [
            'is_hide' => 0,
            'is_recommend' => 0,
        ];
        if($novel_type){
            $search['type'] = $novel_type;
        }
        $result = NovelBase::where($search)->select(
            'id',
            'title',
            'author',
            'status',
            'desc',
            'words',
            'img_url'
        )->orderBy('recommend_num','desc')->take(15)->get();

        return $result;
    }

    //最新更新
    public static function newset($novel_type){
        $search = [
            'is_hide' => 0,
            'is_recommend' => 0,
        ];
        if($novel_type){
            $search['type'] = $novel_type;
        }

        $result = NovelBase::where($search)->select(
            'id',
            'title',
            'author',
            'status',
            'desc',
            'words',
            'img_url'
        )->orderBy('last_update','desc')->take(30)->get();

        return $result;
    }

    //最新入库
    public static function orderNewCreate($novel_type){
        $search = [
            'is_hide' => 0,
            'is_recommend' => 0,
        ];
        if($novel_type){
            $search['type'] = $novel_type;
        }
        $result = NovelBase::where($search)->select(
            'id',
            'title',
            'author',
            'status',
            'desc',
            'words',
            'img_url'
        )->orderBy('created_at','desc')->take(30)->get();

        return $result;
    }

    /**
     * 获取小说主要信息
     * @param $novel_id
     */
    public static function novelBase($novel_id){
        if(!$novel_id){
            static::addError('参数不完整',-1);
            return false;
        }

        $novel_base = NovelBase::find($novel_id);
        if(!$novel_base){
            static::addError('该小说不存在',-1);
            return false;
        }

        return $novel_base;
    }

    /**
     * 获取章节的一条信息
     * @param $novel_id
     * @param $chapter_id
     */
    public static function novelChapter($novel_id,$chapter_id){
        if(!$novel_id || !$chapter_id){
            static::addError('参数不完整',-1);
            return false;
        }

        $novel_detail_table = NovelService::getNovelDetailByNovelId($novel_id);
        $novel_chapter = $novel_detail_table::find($chapter_id);
        if(!$novel_chapter){
            static::addError('该章节不存在',-1);
            return false;
        }

        return $novel_chapter;

    }

    /**
     * 获取章节内容的一条信息
     * @param $novel_id
     * @param $chapter_id
     */
    public static function novelContent($novel_id,$chapter_id,$noly_content = true){
        if(!$novel_id || !$chapter_id){
            static::addError('参数不完整',-1);
            return false;
        }

        $novel_content_table = NovelService::getNovelContentByNovelId($novel_id);
        $novel_content = $novel_content_table::where('capter_id',$chapter_id)->first();
        if(!$novel_content){
            static::addError('该章节不存在',-1);
            return false;
        }

        if($noly_content){
            $novel_content = $novel_content->content; 
        }
        
        return $novel_content;

    }

     /**
     * 检查是否有下一章(是否最后一章)
     * @param $novel_id
     * @param $chapter_id
     */
    public static function hasNextChapter($novel_id,$chapter_id){
        if(!$novel_id || !$chapter_id){
            static::addError('参数不完整',-1);
            return false;
        }
        $novel_detail_table = NovelService::getNovelDetailByNovelId($novel_id);

        $next_detail = $novel_detail_table::where('id','>',$chapter_id)->where('novel_id',$novel_id)->orderBy('id','asc')->first();
        if(!$next_detail){
            static::addError('已经是最后一章了',-1);
            return false;
        }

        return $next_detail;
    }

    /**
     * 检查是否有上一章
     * @param $novel_id
     * @param $chapter_id
     */
    public static function hasLastChapter($novel_id,$chapter_id){
        if(!$novel_id || !$chapter_id){
            static::addError('参数不完整',-1);
            return false;
        }
        $novel_detail_table = NovelService::getNovelDetailByNovelId($novel_id);

        $last_detail = $novel_detail_table::where('id','<',$chapter_id)->where('novel_id',$novel_id)->orderBy('id','desc')->first();
        if(!$last_detail){
            static::addError('已经是第一章了',-1);
            return false;
        }

        return $last_detail;
    }

    /**
     * 抓取一条小说内容
     */
    public static function reptilianContent($url){
        $content = BiQuService::getChapterContent($detail->biqu_url);
        return $content;
    }

    /**
     * 获取小说所属类型
     */
    public static function novelType($type_id){
        if(!$type_id){
            static::addError('参数不完整',-1);
            return false;
        }
        $novel_type = NovelCategory::find($type_id);
        return $novel_type;
    }

    /**
     * 小说最后一条一更新章节
     * @param $novel_id
     */
    public static function finalChapter($novel_id){
        
        $novel_detail_table = NovelService::getNovelDetailByNovelId($novel_id);
        $chapter = $novel_detail_table::where('novel_id',$novel_id)
                    ->where('is_update',1)
                    ->orderBy('id','desc')
                    ->select(
                        'id',
                        'novel_id',
                        'title',
                        'words',
                        'create_at'
                    )
                    ->first();
        $chapter = $chapter ? $chapter->toArray() : [];

        return $chapter;
    }

    /**
     * 小说所有章节
     * @param $novel_id
     */
    public static function novelChapters($novel_id){
        if(!$novel_id){
            static::addError('参数不完整',-1);
            return false;
        }
        $novel_detail_table = NovelService::getNovelDetailByNovelId($novel_id);
        $chapters = $novel_detail_table::where('novel_id',$novel_id)->orderBy('create_at','asc')->get()->toArray();

        return $chapters;
    }

    /**
     * 作者其他作品
     */
    public static function authorOther($novel_id,$author_name){
        if(!$author_name){
            static::addError('参数不完整',-1);
            return false;
        }

        $author_other = NovelBase::where('author',$author_name)->where('id','!=',$novel_id)->select(
            'img_url',
            'title',
            'id'
        )->get();

        return $author_other ?: [];
    }

    //相关推荐
    public static function relevantRecommend($novel_id,$type_id){
        if(!$type_id){
            static::addError('参数不完整',-1);
            return false;
        }
        
        if(!(int)$type_id){
            return [];
        }

        $relevant_recommend = NovelBase::where('type',$type_id)
                            ->where('id','!=',$novel_id)
                            ->offset(0)->limit(5)->select(
                                'id',
                                'title',
                                'img_url'
                            )->orderBy('click_num','desc')->get();

        return $relevant_recommend ?: [];
    }

    //修改小说点击量
    public static function addClickNum($user_ip,$novel_id){
        if(!$user_ip || !$novel_id){
            static::addError('参数不完整',-1);
            return false;
        }

        $key = $novel_id.'_'.$user_ip;
        $history = Cache::get($key);
        if($history){
            return true;
        }

        $history = Cache::put($key,1,60);
        NovelBase::where('id',$novel_id)->increment('click_num');
        return true;
    }

    /**
     * 登录
     * @param $user_name
     * @param $password
     */
    public static function login($user_name,$password){
        if(!$user_name || !$password){
            static::addError('参数不完整',-1);
            return false;
        }

        $member = Member::where('user_name',$user_name)->first();
        if(!$member){
            static::addError('该用户不存在',-1);
            return false;
        }
        
        if(!password_verify($password,$member->password)){
            static::addError('密码错误',-1);
            return false;
        }

        return true;
    }
}