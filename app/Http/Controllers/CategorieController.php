<?php

namespace App\Http\Controllers;

use App\ArticleAS400;
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
        $articles = $this->articles->select('famille')->distinct()->get();
        foreach ($articles as $index => $article) {
            var_dump($article->id);
        }
    }
}
