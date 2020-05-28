<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;

class AdminController extends MainController
{    
    public function edit()
    {  
       
            $titleAdm = "Accueil de l'administration du site";
            $comments = MainModel::loadModel("comments")->notOkComment();
            $nbComments = MainModel::loadModel("comments")->countComments();
            $nbArticles = MainModel::loadModel("articles")->countNoArticles();
            $nbUsers = MainModel::loadModel("users")->countNoUsers();
            $articles   = MainModel::loadModel("Articles")->getAll();
            $users = MainModel::loadModel("Users")->getAll();

            $this->render('admin/Admin_index', Array(
                'titleAdm'  => $titleAdm,
                'comments'  => $comments,
                'nbComments'=> $nbComments,
                'nbArticles'=> $nbArticles,
                'articles'  => $articles,
                'users'     => $users,
                'nbUsers'   => $nbUsers

            )); 
    }
    
}