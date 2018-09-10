<?php
    namespace App\Services\Novel;
    use Illuminate\Support\Facades\Cache;
    use App\Models\NovelCategory;

    class NovelCategoryService {



        public static function  getCategories(){
            return NovelCategory::get();
        }
    }