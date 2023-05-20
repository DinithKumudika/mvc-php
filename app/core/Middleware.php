<?php

namespace App\Core;

class Middleware {

     public const MAPPING = [
          'guest' => Guest::class,
          'auth' => Auth::class
     ];

     public static function resolve($key): void
     {
          if(array_key_exists($key, static::MAPPING)) {
               $middleware = static::MAPPING[$key];

               (new $middleware)->handle();
          }
          else {
               throw \App\Exceptions\MiddlewareException::notFound($key);
          }
     }
}