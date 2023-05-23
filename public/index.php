<?php

use App\Core\Application;
use App\Services\Database;

use App\Controllers\HomeController;
use App\Controllers\UserController;

// entry point for the application
session_start();

$config = require_once '../app/config/config.php';

define('APP_NAME', $config['application']['app_name']);
define('URL_ROOT', $config['application']['url_root']);


$config['application']['debug'] ? ini_set('display_errors', 1) : ini_set('display_errors', 0);

spl_autoload_register(function ($className) {
     $className = str_replace('\\', '/', $className);
     require_once __DIR__ . '/../' . $className . '.php';
});

Application::init($config['application']['app_root']);

Application::bind('App\Services\Database', function(){
     $config = require Application::$ROOT_DIR . 'config/config.php';
     return new Database($config['database']);
});

Application::router()->get('/', [HomeController::class, 'index']);

Application::router()->get('/about', [HomeController::class, 'about']);

Application::router()->get('/contact', [HomeController::class, 'contact']);

Application::router()->get('/user/login', [UserController::class, 'login'])->only('guest');

Application::router()->post('/user/login', [UserController::class, 'handleLogin'])->only('guest');

Application::run();

// try {
//      Application::run();
// }  
// catch (\App\Exceptions\RouteException $e) {
//      Application::router()->renderView('404');
// }
