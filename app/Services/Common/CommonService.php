<?php

namespace App\Services\Common;

use App\Models\NovelBase;
use App\Models\NovelDetail;
use App\Models\NovelCategory;
use App\Models\NovelContent;

use App\Services\BaseService;


class CommonService extends BaseService{

    //搜索
    public static function search($words){
        $search = [
            'is_hide' => 0
        ];
        $result = BaseService::where($search)
                            ->where('title','like','%'.$words.'%')
                            ->select(
                                'id',
                                'title',
                                'author',
                                'status',
                                'words',
                                'img_url'
                            )
                            ->get();
        return $result;
    }

    //推荐
    public static function recommend($novel_type){
        $search = [
            'is_hide' => 0,
            'is_recommend' => 1
        ];
        if($novel_type){
            $search['type'] = $novel_type;
        }
        $result = NovelBase::where($search)->select(
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
    public static function orderCollection($novel_type){
        $search = [
            'is_hide' => 0,
            'is_recommend' => 0,
        ];

        $result = NovelBase::where($search)->select(
            'id',
            'title',
            'author',
            'status',
            'words',
            'img_url'
        )->orderBy('collection_num','desc')->take(15)->get();
        return $result;
    }

    //点击量
    public static function orderClick($novel_type){
        $search = [
            'is_hide' => 0,
            'is_recommend' => 0,
        ];

        $result = NovelBase::where($search)->select(
            'id',
            'title',
            'author',
            'status',
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
        $result = NovelBase::where($search)->select(
            'id',
            'title',
            'author',
            'status',
            'words',
            'img_url'
        )->orderBy('recommend_num','desc')->take(15)->get();

        return $result;
    }

    //最新更新
    public static function orderNewUpdate($novel_type){
        $search = [
            'is_hide' => 0,
            'is_recommend' => 0,
        ];
        $result = NovelBase::where($search)->select(
            'id',
            'title',
            'author',
            'status',
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
        $result = NovelBase::where($search)->select(
            'id',
            'title',
            'author',
            'status',
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
        if(!$result) {
            static::addError('该小说不存在或已被删除',-1);
            return false;
        }
        $result['novel_type'] = NovelCategory::where('id',$result['type'])->pluck('name')->first();
        $chapter = NovelDetail::where('novel_id',$id)
                    ->where('is_update',1)
                    ->orderBy('create_at','desc')
                    ->select(
                        'id',
                        'title',
                        'words',
                        'create_at'
                    )
                    ->first()->toArray();


        return ['novel_base'=>$result,'last_chapter'=>$chapter];
    }

    public static function novelChapters($novel_id){
        $title = NovelBase::where('id',$novel_id)->where('is_hide',0)->pluck('title')->first();
        if (!$title) {
            static::addError('该内容不存在或已被删除',-1);
            return false;
        }
        $chapters = NovelDetail::where('novel_id',$novel_id)->where('is_update',1)->orderBy('create_at','asc')->get()->toArray();

        return ['title' => $title, 'chapters'=>$chapters];
    }

    public static function novelContent($id){
        $detail = NovelDetail::find($id);
        $content = NovelContent::where('capter_id',$id)->pluck('content')->first();
        if(!$detail->is_update || !$content){
            static::addError('该章节不存在或已被删除',-1);
            return false;
        }
        $detail->novel_title = NovelBase::where('id',$detail->novel_id)->pluck('title')->first();

        $detail->content = $content;
        return $detail;
    }
}