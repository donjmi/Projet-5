<?php
namespace Blog\Controllers;

use Blog\Models\MainModel;

class UsersController extends MainController
{  
    public function createUsers()
    {  
        $data= array();
        $post = filter_input_array(INPUT_POST);
        $token = $this->str_random(15);
        if (isset($post)){
            $data['id']         = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $data['pseudo']     = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['email']      = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $data['password']   = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $data['role']       = "member";
            $data['token']      = $token;
        }
        if (isset($post['formuser']) && $this->validateUsers()){
            $data['password']   = password_hash($data['password'], PASSWORD_BCRYPT);

            MainModel::loadModel("Users")->create($data);

            $this->alert('Votre compte a été créé, vous allez recevoir un email pour confirmer !!');
           
            //send email with token
            $this->send_token();
            
            return $this->render('login', array('session' => filter_var_array($_SESSION)));
        }
            $this->render('inscription', Array('user' => $data, 'errors' => $this->notifications,'session' => filter_var_array($_SESSION)));  
    }

    public function update($id){
        $post = filter_input_array(INPUT_POST);
        if (array_key_exists('id', $post) && ! empty($post['id'])){
            $data= array();
            $data['id']         = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $data['pseudo']     = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
            $data['email']      = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $data['email2']     = filter_input(INPUT_POST, 'email2', FILTER_VALIDATE_EMAIL);
            $data['password']   = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $data['password2']  = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_STRING);
            $data['role']       = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

            if (! $this->validateUsers()) {
                $this->render('User_edit', Array('user'=>$data,'action'=>'update','errors'=>$this->notifications,'configs'=> $this->configSite()));
            }
            $data['password']   = password_hash($data['password'], PASSWORD_BCRYPT);
            unset($data['email2']);
            unset($data['password2']);
            $user = MainModel::loadModel("Users")->update($data);
            $this->redirect('admin_index');
        } else {
            $user = MainModel::loadModel("Users")->getOne($id);
            $this->render('User_edit', Array('user'=> $user,'action'=> 'update','errors' => $this->notifications,'configs'=> $this->configSite()));
        }
    }

    public function delete($id){
        $user = MainModel::loadModel("Users")->delete($id);
        $this->redirect('admin_index');
    }

    private function configSite()
    {
        return array(
            'site' => [
                'label' => "gestion de l'utilisateur",
            ]
        );
    }
/*  ------------------ form verifications -----------------------  */

private function isPseudo(){
    $isOk = true;
    $post = filter_input_array(INPUT_POST);
    if (empty($post['pseudo'])){
        $this->notifications[] = "Votre pseudo n'est pas renseigné";
        $isOk = false;
    }else {
        $verifPseudo = MainModel::loadModel("Users")->controlPseudo($post['pseudo']);
        if (empty($post['id']) && !empty($verifPseudo)){
            $this->notifications[] = "Ce pseudo est déjà utilisé";
            $isOk = false;
        }
    }
    return $isOk;
}

private function isEmail(){
    $isOk = true;
    $post = filter_input_array(INPUT_POST);
    if ($post['email2'] != $post['email']){
        $this->notifications[] = "Votre Email de confirmation est différent";
        $isOk = false;
    }else {
        $verifEmail = MainModel::loadModel("Users")->controlEmail($post['email'], $post['id']);
        if (!empty($verifEmail)){
            $this->notifications[] = "Ce Email est déjà utilisé";
            $isOk = false;
        }
    }

    return $isOk;
}

private function isPassword(){
    $isOk = true;
    $post = filter_input_array(INPUT_POST);
    if (empty($post['password']) || $post['password2']!== $post['password']){
        $this->notifications[] = "Mot de passe vide et/ou différent de la confirmation";
        $isOk = false;
    }
    return $isOk;
}
    
    /**
     * validateUsers
     *
     * @return void
     */
    private function validateUsers(){
        $isOk = array();
        $isOk[] = $this->isEmail();
        $isOk[] = $this->isPseudo();
        $isOk[] = $this->isPassword();
        
        return $isOk[0] && $isOk[1] && $isOk[2];
    }


    function str_random($length){
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, $length)),0, $length);
    }


    private function send_token(){
        $pseudo = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        
        $dataUsers  = MainModel::loadModel("Users")->getUserMail($email);
        $userId     = $dataUsers['id'];
        $userToken  = $dataUsers['token'];

        $content = "cliquez sur le lien pour activer votre compte:\n\nhttp://localhost/projet-5/Auth/confirmUser/$userId/$userToken";

        $mailAdmin = ['donjmipub@gmail.com','donjmi'];

        $transport = (new \Swift_SmtpTransport(EMAIL_HOST, EMAIL_PORT))
            ->setUsername(EMAIL_USERNAME)
            ->setPassword(EMAIL_PASSWORD)
            ->setEncryption(EMAIL_ENCRYPTION) //For Gmail 
        ;
        
        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = (new \Swift_Message('My Blog, confirmation de votre compte'))
            ->setFrom([$email => "$pseudo"])
            ->setTo($email)
            ->setCc([$mailAdmin[0]])
            ->setBody($content)
        ;

        $result = $mailer->send($message);
    }
}