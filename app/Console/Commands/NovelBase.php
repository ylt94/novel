<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

use App\Services\RedisService;
use App\Services\ProcessService;
use App\Services\Reptilian\PublicService;

use App\Models\NovelBase as NovelBaseModel;
use App\Models\Sites;
use App\Models\Process;

class NovelBase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:novel_base {start=1} {pid=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $update_seconds = 8*3600;
    protected $sleep_seconds = 4*3600;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        
        $start = $this->argument('start');

        //关闭守护进程
        if(!$start){
            $res = $this->killProcess();
            $action_msg = '守护进程关闭成功';
            if(!$res){
                $action_msg = '守护进程关闭失败';
            }
            $this->info($action_msg);
            exit(0);
        }

        //检查有无此类程序的后台进程
        $process = ProcessService::checkProcess(Process::NOVEL_BASE);
        if(!$process){
            $this->error(ProcessService::getLastError());
            exit;
        }

        //守护进程
        $daemon_res = ProcessService::Daemon();
        if(!$daemon_res){
            //日志
            $this->error(ProcessService::getLastError());
            exit;
        }

        //配置
        $this->update_seconds = $process->update_time;
        $this->sleep_seconds = $process->sleep_time;
        /*
        * 处理业务代码
        */
        Process::where('type',Process::NOVEL_BASE)->update(['pid'=>getmypid()]);
        while(true){
            $time = time()-$this->update_seconds;
            $time = date('Y-m-d H:i:s',$time);
            $novels = NovelBaseModel::where('last_update','<=',$time)->get();
            if(!$novels){
                DB::disconnect();
                sleep($this->sleep_seconds);
                continue;
            }
            foreach($novels as $item){
                //$this->info($item->id);
                RedisService::setNovelId($item->id);
            }
            DB::disconnect();
            sleep($this->sleep_seconds);
        }

    }

    public function killProcess(){

        $action_msg = '正在关闭本次守护进程';
        $pid = $this->argument('pid');
        if($pid){
            $action_msg = '正在关闭守护进程:'.$pid;
        }
        $this->info($action_msg);

        $res = ProcessService::killProcess($pid);
        if($res){
            Process::where('type',Process::NOVEL_BASE)->update(['pid'=>0]);
        }

        return $res;

    }

    
}
