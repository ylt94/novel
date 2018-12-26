<?php

namespace App\Console\Commands\Migrations;

use Illuminate\Console\Command;
use DB;

use App\Services\Novel\NovelService;
use App\Services\PublicService;

use App\Models\NovelBase;
use App\Models\NovelDetail;
use App\Models\NovelContent;
use App\Models\Sites;
use App\Models\Process;

class NovelDetailMi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration:novel_detail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'migration novels';

    protected $novel_base_tables = 1;
    protected $novel_detail_tables = 20;
    protected $novel_content_tables = 20;
    protected $migration_page_num = 1000;
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
    public function handle(){
        $novels = NovelBase::select('id')->get();
        foreach( dataYieldRange($novels) as $novel){
            $this->detail($novel->id);
        }
        $this->info('迁移完成');
    }

    /**
     * 迁移detail表
     */
    public function detail($novel_id){

        $novel_detail_table = NovelService::ChoiceTable($novel_id,$this->novel_detail_tables,'NovelDetail\NovelDetail_');
        $this->info('正在迁移：'.$novel_id.'.......迁移目标表:'.$novel_detail_table);
        $page = 1;
        $details = NovelDetail::where('novel_id',$novel_id)->count();
        $pages = ceil($details/$this->migration_page_num);
        for($page = 1; $page <= $pages; $page++){
            $query = NovelDetail::where('novel_id',$novel_id)->select(
                'id as old_id',
                'site_resource',
                'novel_id',
                'is_free',
                'title',
                'site_id',
                'words',
                'biqu_url',
                'is_update',
                'create_at',
                'created_at',
                'updated_at'
            )->orderBy('id','asc');
            $page_data = PublicService::Paginate($query,$page,$this->migration_page_num,true);
            DB::beginTransaction();
            try{
                $novel_detail_table::insert($page_data['data']);
                DB::commit();
            }catch(\Exception $e){
                DB::rollBack();
                $result = false;
                $this->error('the migrate sql fail:'.$e->getMessage());
            }
        }

        
    }

    
}
