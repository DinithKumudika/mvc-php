<?php

namespace App\Core;

class Response {
     const NOT_FOUND = 404;
     const FORBIDDEN = 403;

     protected array $data;
     
     public function __construct($data)
     {
          $this->data = $data;
     }

     public function toAssoc()
     {

     }

     public function toJson()
     {
          
     }
}