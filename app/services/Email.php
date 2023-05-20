<?php

namespace App\Services;

use Exception;
use App\Utils\Mailer;
use App\Utils\Message;


class Email {

     protected Mailer $mailer;

     public function __construct(Mailer $mailer)
     {
          $this->mailer = $mailer;
     }

     protected function createMessage(string $from, string $to, string $subject, string $body)
     {
          $message = new Message();
          $message->setFrom($from);
          $message->setTo($to);
          $message->setSubject($subject);
          $message->setBody($body);
          return $message;
     }

     public function sendEmail(string $from, string $to, string $subject, string $body) : void
     {
          $message = $this->createMessage($from, $to, $subject, $body);
          $this->mailer->send($message);
     }

}