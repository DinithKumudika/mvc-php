<?php

namespace App\Core;

/* service container */

class Container
{
     protected $bindings = [];
     
     // add things to the container
     public function bind(string $service, callable $resolver)
     {
          $this->bindings[$service] = $resolver;
     }

     // remove things from container
     public function resolve(string $service) : object
     {
          if(!array_key_exists($service, $this->bindings)){
               throw new \Exception('No matching binding found');
          }

          $resolver = $this->bindings[$service];
          
          return call_user_func($resolver);
     }
}