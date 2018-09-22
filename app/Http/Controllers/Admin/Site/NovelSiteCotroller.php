<?php


namespace App\Http\Controllers\Admin\Site;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sites;


class NovelSiteCotroller extends Controller{


    public function siteAdd(Request $request){
        $name = $request->name;
        if(!$name) {
            return ['status'=>0,'msg'=>'请输入网站名称'];
        }

        $check = Sites::where('name',$name)->first();
        if($check) {
            return ['status'=>0,'msg'=>'网站名称已存在'];
        }

        Sites::create(['name'=>$name]);
        return ['status'=>1,'msg'=>'新增成功'];
    }

    public function siteUpdate(Request $request){
        $name = $request->name;
        $id = $request->id;
        if(!$name || !$id) {
            return ['status'=>0,'msg'=>'参数不完整'];
        }

        $check = Sites::find($id);
        if(!$check) {
            return ['status'=>0,'msg'=>'网站不存在'];
        }

        $check->name = $name;
        $check->base_url = $request->base_url;
        $check->detail_url = $request->detail_url;
        $check->content_url = $request->content_url;
        $check->save();
        return ['status'=>1,'msg'=>'修改成功'];
    }

    public function siteDel(Request $request){
        $id = $request->id;
        if(!$id) {
            return ['status'=>0,'msg'=>'参数不完整'];
        }

        Sites::where('id',$id)->delete();
        return ['status'=>1,'msg'=>'删除成功'];
    }

    public function siteSelect(Request $request){
        // $id = $request->id;
        // if(!$id) {
        //     return ['status'=>0,'msg'=>'参数不完整'];
        // }

        $sites = Sites::get();
        return ['status'=>1,'msg'=>'获取成功','data'=>$sites];
    }

}