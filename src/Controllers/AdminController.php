<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;
use Blog\Models\ArticlesModel;

class AdminController extends MainController
{    
    public function edit()
    {  
            $titleAdm = "Accueil de l'administration du site";
            $this->render('admin/Admin_index', Array(
                'titleAdm'  => $titleAdm));
    }   
    
}