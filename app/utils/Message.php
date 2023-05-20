<?php

namespace App\Utils;

class Message
{
     protected $to;
     protected $from;
     protected $subject;
     protected $body;

     public function getTo()
     {
          return $this->to;
     }

     public function setTo($to)
     {
          $this->to = $to;
     }

     public function getFrom()
     {
          return $this->from;
     }

     public function setFrom($from)
     {
          $this->from = $from;
     }

     public function getSubject()
     {
          return $this->subject;
     }

     public function setSubject($subject)
     {
          $this->subject = $subject;
     }

     public function getBody()
     {
          return $this->body;
     }

     public function setBody($body)
     {
          $this->body = $body;
     }
}
