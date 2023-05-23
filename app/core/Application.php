<?php

namespace App\Core;

use App\Core\Router;
use App\Core\Container;

class Application {

     public static string $ROOT_DIR;
     protected static Container $container;
     protected static Router $router;
     protected static Request $request;
     public static Response $response;

     public static function init($rootPath): void 
     {
          self::$ROOT_DIR = $rootPath;
          self::$request = new Request();
          self::$response =  new Response();
          self::$router = new Router(static::$request, static::$response);
          self::$container = new Container();
     }

     public static function router(){
          return self::$router;
     }

     public static function bind(string $service, callable $resolver): void
     {
          self::$container->bind($service, $resolver);
     }

     public static function resolve(string $service): void
     {
          self::$container->resolve($service);
     }

     public static function run(): void
     {
          echo self::$router->resolve();
     }
}