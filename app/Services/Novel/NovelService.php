<?php
    namespace App\Services\Novel;

    use Illuminate\Support\Facades\Request;

    use App\Services\BaseService;
    use App\Services\PublicService;

    use App\Models\NovelCategory;
    use App\Models\NovelBase;
    use App\Models\NovelDetail;
    use App\Models\NovelContent;


    class NovelService extends BaseService{



        public static function novles(Request $request){
            $query = NovelBase::query();
            if($request->name){
                $query->where('title','like','%'.$request->name.'%');
            }

            if($request->type){
                $query->where('type',$request->type);
            }

            if($request->resource){
                $query->where('site_source',$request->resource);
            }

            if($request->author){
                $query->where('author','like','%'.$request->author.'%');
            }

            if($request->status){
                $query->where('status',$request->status);
            }

            if($request->order_by){
                $order_by = explode(',',$request->order_by);
                $query->orderBy($order_by[0],$order_by[1]);
            }

            $page_num = 10;
            $page = $request->page;

            $result = PublicService::Paginate($query,$page,$page_num);
            
            return $result;
            
        }

        public static function getNovelChapters($id,$page = 1,$order_by = 'asc'){
            $query = NovelDetail::where('novel_id',$id)->orderBy('create_at',$order_by);

            $result = PublicService::Paginate($query,$page,$page_num);

            return $result;
            
        }
    }