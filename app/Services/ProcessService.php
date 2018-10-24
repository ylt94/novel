<?php

namespace App\Services;

use App\Services\BaseService;

use App\Models\Process;

class ProcessService extends BaseService{

    //终止进程
    public static function killProcess($_pid = null){

        $pid = $_pid;
        if(!$pid){
            $pid = getmypid();
        }

        $res = posix_kill($pid, 9);
        if(!$res){
            static::addError('进程关闭失败',-1);
        }
        return $res;
    }

    //检查进程唯一性
    public static function checkProcess($type){
        //获取相关配置
        $process = Process::where('type',$type)->first();
        //有进程，先关闭
        if($process->pid){
            $res = self::killProcess($process->pid);
            if(!$res){
                static::addError('已有此类进程且无法关闭,请先关闭',-1);
                return false;
            }
            $process->pid = 0;
            $process->save();
        }
        return $process;
    }

    //守护进程
    public static function Daemon(){
        if (php_sapi_name() != "cli"){
            static::addError('只允许在cli命令下执行',-1);
            return false;
        }

        $pid = pcntl_fork();
        if ($pid == -1){
            static::addError('守护进程开启失败',-1);
        }elseif ($pid > 0){
            //父进程退出,子进程不是进程组长，以便接下来顺利创建新会话
            exit(0);
        }
        
        // 最重要的一步，创建一个新的会话，脱离原来的控制终端
        posix_setsid();
        
        // 修改当前进程的工作目录，由于子进程会继承父进程的工作目录，修改工作目录以释放对父进程工作目录的占用。
        chdir('/');
        
        /*
        * 通过上一步，我们创建了一个新的会话组长，进程组长，且脱离了终端，但是会话组长可以申请重新打开一个终端，为了避免
        * 这种情况，我们再次创建一个子进程，并退出当前进程，这样运行的进程就不再是会话组长。
        */
        $pid = pcntl_fork();
        if ($pid == -1){
            static::addError('守护进程开启失败',-1);
            return false;
        }elseif ($pid > 0){
            //  再一次退出父进程，子进程成为最终的守护进程
            exit(0);
        }
        
        // 由于守护进程用不到标准输入输出，关闭标准输入，输出，错误输出描述符
        fclose(STDIN);
        fclose(STDOUT);
        fclose(STDERR);
        
        return true;
    }
}