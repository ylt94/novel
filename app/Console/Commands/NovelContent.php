<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

use App\Services\RedisService;
use App\Services\Reptilian\QiDianService;
use App\Services\ProcessService;
use App\Services\Reptilian\BiQuService;
use App\Services\Reptilian\PublicService;
use App\Services\PublicService as PS;

use App\Models\NovelDetail;
use App\Models\Sites;
use App\Models\Process;

class NovelContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:novel_content {start=1} {pid=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $sleep_seconds = 10*60;
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
         $process = ProcessService::checkProcess(Process::NOVEL_CONTENT);
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
         $this->sleep_seconds = $process->sleep_time;

        //业务逻辑
        Process::where('type',Process::NOVEL_CONTENT)->update(['pid'=>getmypid()]);
        
        while(true){
            try{
                $result = RedisService::getNovelDetailId();
                if(!$result){
                    DB::disconnect();
                    sleep(3);
                    continue;
                }
                self::checkChannel($result);

                DB::disconnect();
                sleep($this->sleep_seconds);
            }catch(\Exception $e){
                RedisService::setNovelDetailId($result);
                DB::disconnect();
                $message = '章节ID：'.var_export($result,true).'更新出错：'.$e->getFile().$e->getLine().':'.$e->getMessage();
                PS::myLog($message,'logs/daemons/novel_content/','error');
            }
        }
        
        
    }

    public static function checkChannel($item){
        $result = false;
        // switch($novel_detail->site_resource){
        //     case Sites::QIDIAN:
        //         $result = QiDianService::updateContentByQuery($novel_detail);
        //         break;
        //     case Sites::ZONGHENG:
        //         break;
        // }
        // if(!$result){
        //     //$this->info('result-------:'.QiDianService::getLastError());
        // }
        $result = BiQuService::updateChapterContent($item);
        return $result; 
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
            Process::where('type',Process::NOVEL_CONTENT)->update(['pid'=>0]);
        }

        return $res;

    }
}
