<?php

namespace App\Console\Commands\Migrations;

use Illuminate\Console\Command;
use DB;

use App\Services\Novel\NovelService;
use App\Services\PublicService;

use App\Models\NovelDetail;
use App\Models\NovelContent;


class NovelContentMi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migration:novel_content';

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
            $this->content($novel->id);
        }
    }

    /**
     * 迁移content
     */
    public function content($novel_id){
        $novel_detail_table = NovelService::ChoiceTable($novel_id,$this->novel_detail_tables,'NovelDetail\NovelDetail_');
        $novel_content_table = NovelService::ChoiceTable($novel_id,$this->novel_detail_tables,'NovelContent\NovelContent_');

        $page = 1;
        $details = NovelDetail::count();
        $pages = ceil($details/$this->migration_page_num);
        for($page = 1; $page <= $pages; $page++){
            $query = $novel_detail_table::where('novel_id',$novel_id)->select(
                'old_id',
                'novel_id'
            )->orderBy('id','asc');
            $page_data = PublicService::Paginate($query,$page,$this->migration_page_num,true);
            foreach($page_data as $item){
                $content = NovelContent::where('capter_id',$item['old_id'])->select(
                    'capter_id',
                    'content',
                    'created_at',
                    'updated_at'
                )->first();
                if($content){
                    DB::beginTransaction();
                    try{
                        $content = $content->toArray();
                        $content['capter_id'] = $item['id'];
                        $novel_content_table::insert($content);
                        DB::commit();
                    }catch(\Exception $e){
                        DB::rollBack();
                        break;
                        $this->error('the migrate sql fail:'.$e->getMessage());
                    }
                    
                }
            }
            
        }
    }
    
}
