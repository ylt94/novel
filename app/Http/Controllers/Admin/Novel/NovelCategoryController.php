<?php


namespace App\Http\Controllers\Admin\Novel;

use App\Http\Controllers\Controller;
use App\Models\NovelCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NovelCategoryController extends Controller{


    public function getCategory(Request $request){

        $query = NovelCategory::query();
        if($request->type_id) {
            $query->where('type_id',$request->type_id);
        }
        $data = $query->get();
        return ['status'=>1,'msg'=>'','data'=>$data];
    }

    public function categoryAddOrUpdate(Request $request){
        $data = $request->all();

        $validata = [
            'name'=>'required|unique:novel_category,name',
            'pid'=>'required',
            'type_id'=>'required'
        ];
        $validator = Validator::make($data,$validata);
        if( $validator->fails() ){
            return ['status'=>0,'msg'=>'参数不完整或数据重复!'];
        }

        if($data['pid']){
            $search_where = array(
                'pid'=>$data['pid'],
                'type_id'=>$data['type_id']
            );
            $data_check =  NovelCategory::where($search_where)->first();
            if(!$data_check) {
                return ['status'=>0,'msg'=>'数据异常!'];
            }
        }

        $_data = [
            'name'=>$data['name'],
            'pid'=>$data['pid'],
            'type_id'=>$data['type_id']
        ];
        if($data['id']) {
            NovelCategory::where('id',$data['id'])->update($_data);
        }else{
            NovelCategory::create($_data);
        }

        return ['status'=>1];


    }

    public function categoryDel(Request $request){
        $id = $request->id;

        if(!$id) {
            return ['status'=>0,'msg'=>'参数错误！'];
        }

        NovelCategory::where('id',$id)->delete();

        return ['status'=>1];

    }

    public function categorySort(Request $request){
        $last_id = $request->last_id;
        $font_id = $request->font_id;
        if(!$last_id || !$font_id){
            return['status'=>0,'msg'=>'参数不完整'];
        }

        if(abs($font_id-$last_id) == 1) {
            return ['status'=>1];
        }

        $font_check = NovelCategory::where('id',$font_id)->first();
        if(!$font_check || $font_id == $last_id ) {
            return ['status'=>0,'msg'=>'数据异常'];
        }

        if($last_id > $font_id) {//变化的数据font_id < update_data <= last_id
            $update_data = NovelCategory::where('id','>',$font_id)->where('id','<=',$last_id)->get()->toArray();
        }else{
            $update_data = NovelCategory::where('id','>=',$last_id)->where('id','<=',$font_id)->get()->toArray();   
        }
        $new_data = $update_data;
        foreach ($new_data as &$item) {
            $item['updated_at'] = $item['created_at'] = date('Y-m-d H:i:s',time());
            if($item['id'] == $last_id) {
                if($last_id > $font_id) {
                    $item['id'] = $font_id+1;
                }else{
                    $item['id'] = $font_id;
                }
                continue;
            }
            if($last_id > $font_id){
                $item['id']++;
            }else{
                $item['id']--;
            }
            
        }
        unset($item);
        DB::beginTransaction();
        try{
            NovelCategory::where('id','>=',$update_data[0]['id'])->where('id','<=',$update_data[count($update_data)-1]['id'])->delete();
            NovelCategory::insert($new_data);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return ['status'=>0,'msg'=>$e->getMessage()];
        }
        return ['status'=>1];
        
    }
}