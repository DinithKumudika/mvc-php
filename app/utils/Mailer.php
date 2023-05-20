<?php

namespace App\Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require './vendor/autoload.php';

/*   Mailer service used by Email service container
     configure with mailing service you want to use
     default is PHPMailer
*/

class Mailer {

     private PHPMailer $mailer;
     protected string $to;
     protected string $from;
     protected string $subject;
     protected string $body;

     public function __construct()
     {
          $this->mailer = new PHPMailer(true);

          $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;                 //Enable verbose debug output
          $this->mailer->isSMTP();                                       //Send using SMTP
          $this->mailer->Host       = 'smtp.example.com';                //Set the SMTP server to send through
          $this->mailer->SMTPAuth   = true;                              //Enable SMTP authentication
          $this->mailer->Username   = 'user@example.com';                //SMTP username
          $this->mailer->Password   = 'secret';                          //SMTP password
          $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;    //Enable implicit TLS encryption
          $this->mailer->Port       = 587;                               //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
     }

     public function send(Message $message)
     {
          
          try {
               $this->mailer->setFrom($message->getFrom());
               $this->mailer->addAddress($message->getTo());  //Add a recipient

               $this->mailer->isHTML(true);                   //Set email format to HTML
               $this->mailer->Subject = $message->getSubject();
               $this->mailer->Body = $message->getBody();
               $this->mailer->AltBody = $message->getBody();

               $this->mailer->send();
          } 
          catch (Exception $e){
               echo 'Email could not be sent. Error: ' . $this->mailer->ErrorInfo;
          }
     }
}