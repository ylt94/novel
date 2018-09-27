<?php

namespace App\Http\Controllers\Admin\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Member;

use App\Services\Member\MemberService;


class MemberController extends Controller{


    public function members(Request $request){
        $query = Member::query();

        if($request->start_time){
            $query->where('created_at','>=',$request->start_time);
        }

        if($request->end_time){
            $query->where('created_at','<=',$request->end_time);
        }

        $data = $query->orderBy('created_at','desc')->get();

        return ret_res(1,1000,$data);
    }

    public function disabled(Request $request){
        $id = $request->id;
        $is_disabled = $request->is_disabled;
        if(!$id || !isset($is_disabled)){
            return ret_res(0,2006);
        }

        $member = Member::find($id);
        if(!$member){
            return ret_res(0,2007);
        }

        $member->is_disabled = $is_disabled;
        $member->save();

        return ret_res(1,1002);
    }
}