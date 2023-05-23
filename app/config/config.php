<?php

namespace normPHP\App\Config; 

return [
     'application' => [
          'app_name' => 'mvc-template',
          'app_version' => '1.0',
          'app_root' => dirname(__FILE__, 2),
          'base_path' => dirname(__FILE__, 3),
          'url_root' => 'http://localhost/mvc-template',
          'debug' => true
     ],

     'database' => [
          'driver' => 'mysql',
          'charset' => 'utf8mb4',
          'host' => 'localhost',
          'user' => 'root',
          'pass' => '',
          'dbname' => ''
     ],

     'email' => [
          
     ]
];