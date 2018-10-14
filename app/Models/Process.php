<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process extends Model{
    protected $table="process";
    protected $guarded=[];


    const NOVEL_BASE = 'novel_base';
    const NOVEL_DETAIL = 'novel_detail';
    const NOVEL_CONTENT = 'novel_content';
}