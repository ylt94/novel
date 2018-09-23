<?php
    namespace App\Services\Novel;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

    use App\Services\BaseService;
    use App\Services\PublicService;

    use App\Models\NovelCategory;
    use App\Models\NovelBase;
    use App\Models\NovelDetail;
    use App\Models\NovelContent;


    class NovelService extends BaseService{



        public static function novles(Request $request){
            $query = NovelBase::query();
            if($request->title){
                $query->where('title','like','%'.$request->title.'%');
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

        public static function delNovel($id){
            try{
                DB::beginTransaction();
                NovelBase::where('id',$id)->delete();
                $chapter_ids = NovelDetail::where('novel_id',$id)->public('id')->get();
                NovelDetail::where('novel_id',$id)->delete();
                NovelContete::whereIn('capter_id',$chapter_ids)->delete();
                DB::commit();
            }catch(\Exception $e){
                DB::rollBack();
                static::addError(-1,$e->getMessage());
                return false;
            }
            return true;
        }

        public static function getNovelChapters($id,$page = 1,$order_by = 'asc'){
            $query = NovelDetail::where('novel_id',$id)->orderBy('create_at',$order_by);

            $page_num = 10;
            $result = PublicService::Paginate($query,$page,$page_num);

            return $result;
            
        }
    }