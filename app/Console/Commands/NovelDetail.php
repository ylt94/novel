<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\RedisService;
use App\Services\Reptilian\QiDianService;

use App\Models\NovelBase;
use App\Models\Sites;

class NovelDetail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update_novel_detail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $novel_id = RedisService::getNovelId();
        if($novel_id && $novel_base = NovelBase::find($novel_id)) {
            self::checkChannel($novel_base);
        }
    }

    public static function checkChannel(NovelBase $novel_base){
        switch($novel_base->site_resource){
            case Sites::QIDIAN:
                $result = QiDianService::updateDetailByQuery($novel_base);
                break;
        }
    }
}
