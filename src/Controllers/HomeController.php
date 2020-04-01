<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;

/**
 * class HomeController
 * Manages the Homepage
 */
class HomeController extends MainController
{    
    /**
     * Renders the view Home + flux rss
     */
    public function defaultMethod()
    {
        $articles = MainModel::loadModel("Articles")->getLimit();
        $this->render('home', Array(
            'articles' => $articles,
            'rssItems' => $this->fluxrss()->channel->item
        ));  
    }
    /**
     * Renders the view Home + flux rss
     */
    public function listArticles()
    {
        $articles = MainModel::loadModel("Articles")->getAll();
        $this->render('articles', Array(
            'articles' => $articles
        ));  
    }
    
    /**
     * fluxrss
     *
     * @return void
     */
    public function fluxrss()
    {
        return MainModel::loadModel("Articles")->flux();
    }
  
}
