<?php
namespace Blog\Controllers;

// use Blog\Models\HomeModel;
use Blog\Models\MainModel;

class HomeController extends MainController
{
    public function defaultMethod()
    {
        $articles = MainModel::loadModel("Articles")->getAll();

        $this->render('home', Array(
            'articles' => $articles,
            'rssItems' => $this->fluxrss()->channel->item
        ));  
    }

    public function fluxrss()
    {
        return MainModel::loadModel("Articles")->flux();
    }
  
}
