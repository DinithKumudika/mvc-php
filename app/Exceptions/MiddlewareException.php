<?php
namespace App\Exceptions;

class MiddlewareException extends \Exception {

     public static function notFound($key): static
     {
          return new static("No matching middleware found for key {$key}.");
     }
}