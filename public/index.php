<?php

use App\Core\Application;
use App\Services\Database;

// entry point for the application
session_start();

$config = require_once '../app/config/config.php';

define('APP_ROOT', $config['application']['app_root']);
define('APP_NAME', $config['application']['app_name']);
define('URL_ROOT', $config['application']['url_root']);

spl_autoload_register(function ($className) {
     $className = str_replace('\\', '/', $className);
     require_once __DIR__ . '/../' . $className . '.php';
});

Application::init();

Application::bind('App\Services\Database', function(){
     $config = require APP_ROOT . 'config/config.php';
     return new Database($config['database']);
});

try {
     /* add all your routes here */

     Application::router()->get('/', 'home/index');

     Application::router()->get('/about', 'home/about');

     Application::router()->get('/contact', 'home/contact');

     Application::router()->get('/user/login', 'user/login')->only('guest');

     Application::run();
}  
catch (\App\Exceptions\RouteException $e) {
     App\Core\Controller::view('pages/404', [
          'title'=>'404'
     ]);
}
