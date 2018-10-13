<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\RedisService;

use App\Models\NovelBase as NovelBaseModel;
use App\Models\Sites;

class NovelBase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update_novel_base';

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
        //
        // while(true){
        //     $time = time()-$this->update_seconds;
        //     $time = date('Y-m-d H:i:s',$time);
        //     $novels = NovelBaseModel::where('last_update','<=',$time)->get();
        //     if(!$novels){
        //         sleep($this->sleep_seconds);
        //         continue;
        //     }
        //     foreach($novels as $item){
        //         $this->info($item->id);
        //         RedisService::setNovelId($item->id);
        //     }
        //     sleep($this->sleep_seconds);
        // }
        $ppid = posix_getpid();
        $pid = pcntl_fork();
        if ($pid == -1) {
            throw new Exception('fork子进程失败!');
        } elseif ($pid > 0) {
            cli_set_process_title("我是父进程,我的进程id是{$ppid}.");
            sleep(30);
        } else {
            $cpid = posix_getpid();
            cli_set_process_title("我是{$ppid}的子进程,我的进程id是{$cpid}.");
            sleep(30);
        }
    }
}
