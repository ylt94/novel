<?php
    namespace App\Services\Novel;

    use Illuminate\Support\Facades\Cache;

    use App\Models\NovelCategory;

    use App\Services\BaseService;

    class NovelCategoryService extends BaseService{



        public static function  getCategories(){
            return NovelCategory::get();
        }
    }