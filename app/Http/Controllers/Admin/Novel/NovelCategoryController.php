<?php


namespace App\Http\Controllers\Admin\Novel;

use App\Http\Controllers\Controller;
use App\Models\NovelCategory;

class NovelCategoryController extends Controller{


    public function getCategory(){
        return NovelCategory::get();
    }
}