<?php


namespace App\Http\Controllers\Admin\Set;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Services\ProcessService;

use App\Models\Process;


class ProcessController extends Controller{
    
    /**
     * 进程列表
     */
    public function processList(){
        $process = Process::get();
        return ret_res(1,1000,$process);
    }

    /**
     * 修改进程
     */
    public function updateProcess(Request $request){
        $id = $request->id;
        $data = $request->all();

        if(!$id){
            return ret_res(0,2006);
        }

        Process::where('id',$id)->update($data);

        return ret_res(1,1002);
    }

    /**
     * 删除进程
     */
    public function delProcess(Request $request){
        $id = $request->process_id;
        if(!$id){
            return ret_res(0,2006);
        }
        $process = Process::find($id);
        if ($process->pid) {
            $res = ProcessService::killProcess($process->pid);
            if(!$res){
                return ret_res(0,2001);
            }
        }
        $process->delete();

        return ret_res(1,1004);
    }

    /**
     * 新增进程
     */
    public function addProcess(Request $request){
        $data = $request->all();

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
        $cd = 'cd /var/www/novel && ';
        $cd_res = exec($cd.$process->exec_command);dd($cd_res);
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