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
        if (php_sapi_name() != "cli"){
            $this->error('只允许在cli命令下执行');
            exit(0);
        }

        $start = $this->argument('start');
        if(!$start){
            $pid = $this->argument('pid');
            $this->info('正在关闭守护进程:'.$pid);
            $res = posix_kill($pid, 9); 
            if(!$res){
                $this->info('守护进程关闭失败');
            }else{
                $this->info('守护进程关闭成功');
            }
            //posix_kill(0,SIGKILL);
            exit(0);
        }
        
        $pid = pcntl_fork();
        if ($pid == -1)
        {
            $this->error('守护进程开启失败');
        }elseif ($pid > 0){
            //父进程退出,子进程不是进程组长，以便接下来顺利创建新会话
            $this->info('父进程退出成功1');
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
        if ($pid == -1)
        {
            $this->error('守护进程开启失败');
        }elseif ($pid > 0)
        {
            //  再一次退出父进程，子进程成为最终的守护进程
            $this->info('父进程退出成功2');
            exit(0);
        }
        
        // 由于守护进程用不到标准输入输出，关闭标准输入，输出，错误输出描述符
        fclose(STDIN);
        fclose(STDOUT);
        fclose(STDERR);
        
        /*
        * 处理业务代码
        */
        $this->info('守护进程开启成功');
        while(true){
            $this->info('守护进程运行中.....'.posix_getpid());
            $this->info('---->',getmypid());
            sleep(20);
        }
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

    }
}
