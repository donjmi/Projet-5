<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;

class AdminController extends MainController
{        
    /**
     * edit administration page
     *
     */
    public function edit($id=null)
    {  
        if ($this->session->getUserVar('role') === 'admin') {
            $titleAdm   = "Accueil de l'administration du site";
            $comments   = MainModel::loadModel("comments")->notOkComment();
            $nbComments = MainModel::loadModel("comments")->countComments();
            $nbOkComments = MainModel::loadModel("comments")->countOkComments();
            $nbArticles = MainModel::loadModel("articles")->countNoArticles();
            $nbUsers    = MainModel::loadModel("users")->countNoUsers();
            $articles   = MainModel::loadModel("Articles")->getAll();
            $okComments = MainModel::loadModel("comments")->okComment($id);
            $users      = MainModel::loadModel("Users")->getAll();

            $this->render('admin/Admin_index', Array(
                'titleAdm'  => $titleAdm,
                'comments'  => $comments,
                'nbComments'=> $nbComments,
                'nbOkComments'=> $nbOkComments,
                'okComments'=> $okComments,
                'nbArticles'=> $nbArticles,
                'articles'  => $articles,
                'users'     => $users,
                'nbUsers'   => $nbUsers,
                'session'   => filter_var_array($_SESSION),

            ));
        }
        $this->alert("Connectez vous en tant administrateur !");
        $this->render('login', Array(
            'session' => filter_var_array($_SESSION),));   
    }
    
}