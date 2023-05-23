<?php

namespace App\Controllers;

use App\Core\Application;

class UserController {
     
     public function login()
     {
          return Application::router()->renderView('user/login', ['title'=>'Login']);
     }

     public function handleLogin()
     {

     }
}