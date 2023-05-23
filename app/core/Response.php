<?php

namespace App\Core;

class Response {
     protected array $data;


     public function setStatusCode(int $code): void
     {
          http_response_code($code);
     }

     public function toAssoc()
     {

     }

     public function toJson()
     {
          
     }
}