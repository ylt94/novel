<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

use App\Services\RedisService;
use App\Services\ProcessService;
use App\Services\Reptilian\QiDianService;
use App\Services\Reptilian\PublicService;

use App\Models\NovelBase as NovelBaseModel;
use App\Models\Sites;
use App\Models\Process;

class NovelNew extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:novel_new {start=1} {pid=0}';

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
        $process = ProcessService::checkProcess(Process::NOVEL_NEW);
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
        Process::where('type',Process::NOVEL_NEW)->update(['pid'=>getmypid()]);
        $url = env('QIDIAN_NEW_NOVELS_URL');
        $max_page = env('QIDIAN_NEW_NOVELS_PAGES');
        $page = 1;
        while(true){
            $url = $url.$page;
            QiDianService::getNewNovels($url);
            DB::disconnect();
            $page++;
            if($page > $max_page){
                $page = 1;
                $time = PublicService::createRandomNumber(1200,3600);
                $sleep_seconds = ($time%2) ? ($this->sleep_seconds+$time) : ($this->sleep_seconds-$time);
                sleep($sleep_seconds);
            }else{
                $time = PublicService::createRandomNumber(10,100);
                sleep(60); 
            }
            
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
