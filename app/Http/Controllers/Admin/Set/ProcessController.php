<?php


namespace App\Http\Controllers\Admin\Set;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Process;


class ProcessController extends Controller{
    

    public function processList(){
        return Process::get();
    }

    public function updateProcess(Request $request){
        $id = $request->process_id;
        $data = $request->update_data;

        if(!$id){
            return ret_res(0,2006);
        }

        Process::where('id',$id)->update($data);

        return ret_res(1,1002);
    }

    public function delProcess(Request $request){
        $id = $request->process_id;
        if(!$id){
            return ret_res(0,2006);
        }

        Process::where('id',$id)->delete();

        return ret_res(1,1004);
    }

    public function addProcess(Request $request){
        $data = $request->update_data;

        $rules = [
            'type' => 'required',
            'update_time' => 'required',
            'sleep_time' => 'required',
        ];
        $validator = Validator::make($data,$rules);
        if($validator->fails()){
            return ret_res(0,2006);
        }

        Process::create($data);

        return ret_res(1,1003);
    }
}