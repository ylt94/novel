<?php

namespace App\Services\Common;

use App\Models\NovelBase;
use App\Models\NovelDetail;
use App\Models\NovelCategory;
use App\Models\NovelContent;

use App\Services\BaseService;
use App\Services\Reptilian\BiQuService;
use App\Services\RedisService;


class CommonService extends BaseService{

    //搜索
    public static function search($words){
        $search = [
            'is_hide' => 0,
            'title' => $words
        ];
       
        $novel_id = NovelBase::where($search)->pluck('id')->first();
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
            RedisService::setNovelDetailId($chapter['id']);
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

    public static function novelDetail($id){
        $search = [
            'id' => $id,
            'is_hide' => 0
        ];
        $result = NovelBase::where($search)->first()->toArray();
        $result['words'] = bcdiv($result['words'],10000,2);
        if(!$result) {
            static::addError('该小说不存在或已被删除',-1);
            return false;
        }
        if((int)$result['type']){
            $result['novel_type'] = NovelCategory::where('id',$result['type'])->pluck('name')->first();
        }
        $chapter = NovelDetail::where('novel_id',$id)
                    ->where('is_update',1)
                    ->orderBy('id','desc')
                    ->select(
                        'id',
                        'title',
                        'words',
                        'create_at'
                    )
                    ->first();
        $chapter = $chapter ? $chapter->toArray() : [];

        return ['novel_base'=>$result,'last_chapter'=>$chapter];
    }

    public static function novelChapters($novel_id){
        $title = NovelBase::where('id',$novel_id)->where('is_hide',0)->pluck('title')->first();
        if (!$title) {
            static::addError('该内容不存在或已被删除',-1);
            return false;
        }
        $chapters = NovelDetail::where('novel_id',$novel_id)->orderBy('create_at','asc')->get()->toArray();

        return ['title' => $title, 'chapters'=>$chapters];
    }

    public static function novelContent($id){
        $detail = NovelDetail::find($id);
        $content = NovelContent::where('capter_id',$id)->pluck('content')->first();
        if(!$content && !$detail->biqu_url){
            static::addError('该章节不存在或已被删除',-1);
            return false;
        }
        //没有内容，抓取
        if(!$content && $detail->biqu_url){
            $content = BiQuService::getChapterContent($detail->biqu_url);
            if($detail->is_update){
                $insert_data = [
                    'capter_id' => $id,
                    'content' => $content,
                ];
                NovelContent::create($insert_data);
            }
        }
        if(!$content){
            static::addError('该章节不存在或已被删除',-1);
            return false;
        }
        $detail->novel_title = NovelBase::where('id',$detail->novel_id)->pluck('title')->first();

        $detail->content = $content;
        return $detail;
    }

    public static function nextContent($chapter_id){
        $detail = NovelDetail::find($chapter_id);
        $novel_id = $detail->novel_id;
        $next_detail = NovelDetail::where('id','>',$chapter_id)->where('novel_id',$novel_id)->orderBy('id','asc')->first();
        if(!$next_detail){
            return false;
        }
        
        $content = NovelContent::where('capter_id',$next_detail->id)->pluck('content')->first();
        if(!$content && $next_detail->biqu_url){
            $content = BiQuService::getChapterContent($next_detail->biqu_url);
        }
        if(!$content){
            static::addError('该章节不存在或已被删除',-1);
            return false;
        }
        $next_detail->novel_title = NovelBase::where('id',$novel_id)->pluck('title')->first();
        $next_detail->content = $content;

        return $next_detail;
    }
}