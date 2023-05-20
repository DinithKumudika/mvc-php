<?php

namespace App\Core;

use App\Core\Router;
use App\Core\Container;

class Application {

     protected static Container $container;
     protected static Router $router;
     protected static Request $request;


     public static function init(): void 
     {
          static::$request = new Request();
          static::$router = new Router(static::$request);
          static::$container = new Container();
     }

     public static function router(){
          return static::$router;
     }

     public static function bind(string $service, callable $resolver): void
     {
          static::$container->bind($service, $resolver);
     }

     public static function resolve(string $service): void
     {
          static::$container->resolve($service);
     }

     public static function run(): void
     {
          echo static::$router->resolve();
     }
}