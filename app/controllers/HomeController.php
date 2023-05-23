<?php

namespace App\Controllers;

use App\Core\Application;

class HomeController {
     
     public function index()
     {
          return Application::router()->renderView('home/index', ['title'=>'Home']);
     }

     public function about()
     {
          return Application::router()->renderView('home/about', ['title'=>'About Us']);
     }

     public function contact()
     {
          return Application::router()->renderView('home/contact', ['title'=>'Contact Us']);
     }
}