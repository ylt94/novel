<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sites extends Model{
    protected $table="sites";
    protected $guarded=[];


    const QIDIAN = 1;
    const ZONGHENG = 2;
}