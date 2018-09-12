<?php

namespace App\Http\Controllers;

use App\ArticleAS400;
use App\Categories;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * @var \App\ArticleAS400
     */
    private $articles;

    /**
     * CategorieController constructor.
     */
    public function __construct(ArticleAS400 $articles)
    {
        $this->articles = $articles;
    }

    public function index()
    {
        $articles = $this->articles->select('famille')->distinct()->get()->pluck('famille','famille');

        $catModel = Categories::get();

        $cat = $catModel->pluck('famille','famille');

        $diffs = array_diff($articles->toArray(), $cat->toArray());

        foreach ($diffs as $index => $diff) {
            $model = $catModel->first()->newInstance();
            $model->famille = $diff ;
            $model->save();
        }

        foreach ($articles as $index => $article) {

        }
    }
}
