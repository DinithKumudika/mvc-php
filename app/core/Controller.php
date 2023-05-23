<?php

namespace App\Core;

class Controller 
{
     public static function view($view, $data = []){
          extract($data);
          require APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view . '.view.php';
     }
}