<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{

    public $table="categories";
    protected $fillable = ['therm','mic','pisto','las','as','jet','tps','mo'];
    public $timestamps = false;
}
