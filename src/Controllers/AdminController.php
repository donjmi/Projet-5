<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;
use Blog\Controllers\CommentsController;
use Blog\Models\ArticlesModel;

class AdminController extends MainController
{    
    public function edit()
    {  
            $titleAdm = "Accueil de l'administration du site";
            // $comments = MainModel::loadModel("comments")->noValidate();
            $comments = MainModel::loadModel("comments")->notOkComment();
            $nbComments = MainModel::loadModel("comments")->countComments();
            $nbArticles = MainModel::loadModel("articles")->countNoArticles();

            $this->render('admin/Admin_index', Array(
                'titleAdm'  => $titleAdm,
                'comments'  => $comments,
                'nbComments'=> $nbComments,
                'nbArticles'=> $nbArticles
                // 'nbUsers'=> $nUsers

            )); 
    }
    
}