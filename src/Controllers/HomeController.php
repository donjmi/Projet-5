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
        $articles = MainModel::loadModel("home")->getLimit();
        $this->render('home', Array(
            'articles' => $articles,
            'rssItems' => $this->fluxrss()->channel->item,
            'session' => filter_var_array($_SESSION)
        ));  
    }
    /**
     * Renders the view Home + flux rss
     */

    
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
