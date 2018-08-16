<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleAS400 extends Model
{
    protected $table = 'articles';

    protected $primaryKey = 'article';

    protected $connection = 'eurocomputer';

    public $incrementing = false;


}
