<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\RedisService;
use App\Services\Reptilian\QiDianService;

use App\Models\NovelDetail;
use App\Models\Sites;

class NovelContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update_novel_content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $sleep_time = 10*60;
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
        while(true){
            $detail_id = RedisService::getNovelDetailId();
            if($detail_id && $novel_detail = NovelDetail::find($detail_id)) {
                self::checkChannel($novel_detail);
            }
            sleep($this->sleep_time);
        }
        
    }

    public static function checkChannel(NovelDetail $novel_detail){
        $result = false;
        switch($novel_detail->site_resource){
            case Sites::QIDIAN:
                $result = QiDianService::updateContentByQuery($novel_detail);
                break;
            case Sites::ZONGHENG:
                break;
        }
        if(!$result){
            //$this->info('result-------:'.QiDianService::getLastError());
        }
        return $result; 
    }
}
