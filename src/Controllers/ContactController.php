<?php
namespace Blog\Controllers;

/**
 * class ContactController
 * Manages the contact
 */
class ContactController extends MainController
{    
    public function send()
    {
        $post = filter_input_array(INPUT_POST);
        if ($post){
            // @TODO send mail
            $surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);
            $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
            
            $this->send_mail();
            // @TODO redirection with notification to user
            $this->alert("Votre message a bien été envoyé !");
            // $this->redirect('home');
            return $this->render('home');
        }

    }

    private function send_mail(){
        $surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);

        $mailAdmin = ['donjmipub@gmail.com','donjmi'];

        $transport = (new \Swift_SmtpTransport(EMAIL_HOST, EMAIL_PORT))
        ->setUsername(EMAIL_USERNAME)
        ->setPassword(EMAIL_PASSWORD)
        ->setEncryption(EMAIL_ENCRYPTION) //For Gmail 
        ;
        
        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = (new \Swift_Message('My blog contact'))
        ->setFrom([$mail => "$name $surname"])
        ->setTo($mail)
        ->setCc([$mailAdmin[0]])
        ->setBody($content)
        ;

        $result = $mailer->send($message);
    }
  
}
