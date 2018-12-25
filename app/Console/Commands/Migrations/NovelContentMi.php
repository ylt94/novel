<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

use App\Services\Novel\NovelService;
use App\Services\PublicService;

use App\Models\NovelContent;


class NovelContentMi extends Command
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
        $novel_detail_table = NovelService::ChoiceTable($novel_id,$this->novel_detail_tables,'NovelContent\NovelContent_');

        $page = 1;
        $details = NovelDetail::where('novel_id',$novel_id)->count();
        $pages = ceil($details/$this->migration_page_num);
        for($page = 1; $page <= $pages; $page++){
            $query = NovelDetail::where('novel_id',$novel_id)->select(
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
