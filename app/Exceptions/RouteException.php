<?php

namespace App\Exceptions;

class RouteException extends \Exception {

     public static function notFound(): static
     {
          return new static('No matching route found');
     }
}