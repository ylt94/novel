<?php


namespace App\Http\Controllers\Admin\Set;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Services\ProcessService;

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

    //启动/重启守护进程
    public function startProcess(Request $request){
        $id = $request->id;
        if(!$id){
            return ret_res(0,2006);
        }
        $process = Process::find($id);
        if(!$process){
            return ret_res(0,2008);
        }

        exec($process->exec_command);
        return ret_res(1,1001);
    }

    //停止守护进程
    public function stopProcess(Request $request){
        $id = $request->id;
        if(!$id){
            return ret_res(0,2006);
        }

        $process = Process::find($id);

        $res = ProcessService::killProcess($process->pid);
        if(!$res){
            return ret_res(0,2001);
        }
        $process->pid = 0;
        $process->save();

        return ret_res(1,1001);
    }
}