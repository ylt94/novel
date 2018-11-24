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

use App\Models\NovelBase;
use App\Models\NovelDetail as NovelDetailTable;
use App\Models\Sites;
use App\Models\Process;

class NovelDetail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:novel_detail {start=1} {pid=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $sleep_seconds = 60;

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
        $process = ProcessService::checkProcess(Process::NOVEL_DETAIL);
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
        Process::where('type',Process::NOVEL_DETAIL)->update(['pid'=>getmypid()]);
        
        while(true){
            try{
                $novel_id = RedisService::getNovelId();
                if(!$novel_id) {
                    DB::disconnect();
                    sleep(3);
                    continue;
                }
                $result = self::checkChannel($novel_id);
                if($result){
                    self::setNovelDetailId($novel_id);
                }
                DB::disconnect();
                sleep($this->sleep_seconds);
            }catch(\Exception $e){
                DB::disconnect();
                $message = '更新出错：'.$e->getFile().$e->getLine().':'.$e->getMessage();
                PS::myLog($message,'logs/daemons/novel_detail/','error');
            }
        }
        
        
    }

    public static function checkChannel($novel_id){
        $result = false;
        // switch($novel_base->site_source){
        //     case Sites::QIDIAN:
        //         $result = QiDianService::updateDetailByQuery($novel_base);
        //         break;
        //     case Sites::ZONGHENG:
        //         break;
        // }
        // if(!$result){
        //     //$this->info('result-------:'.QiDianService::getLastError());
        // }
        $result = BiQuService::updateDetail($novel_id);
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
            Process::where('type',Process::NOVEL_DETAIL)->update(['pid'=>0]);
        }

        return $res;

    }

    /**
     * 插入要更新章节内容的小说章节ID
     */
    public static function setNovelDetailId($novel_id){

        $search = [
            'novel_id' => $novel_id,
            'is_update' => 0
        ];
        $novel_detail_ids = NovelDetailTable::where($search)->pluck('id')->all();
        if(!$novel_detail_ids){
            return true;
        }

        foreach($novel_detail_ids as $val){
            RedisService::setNovelDetailId($val);
        }
        return true;
    }
}
