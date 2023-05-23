<?php

namespace App\Core;

class Request {

     const METHOD_GET = "GET";
     const METHOD_POST = "POST";

     public function sanitize($value, $method)
     {
          return htmlspecialchars($value);
     }

     // get request uri
     public function getPath(): string
     {
          //$path = $_SERVER['REQUEST_URI'] ?? '/';
          $path = explode(APP_NAME, $_SERVER['REQUEST_URI'])[1];
          $pos = strpos($path, '?');
          if($pos == false){
               return $path;
          }

          return substr($path, 0, $pos);
          
          //return parse_url(explode(\APP_NAME, $_SERVER['REQUEST_URI'])[1])['path'];
     }

     // get request method
     public function getMethod(): string
     {
          return $_SERVER['REQUEST_METHOD'];
     }

     public function getBody(){
          
     }
}