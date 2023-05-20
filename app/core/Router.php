<?php

namespace App\Core;

class Router
{
     public Request $request;

     // add your routes to this array
     protected array $routes = [];


     public function __construct(Request $request)
     {
          $this->request = $request;
     }

     public function resolve()
     {
          $uri = $this->request->getPath();
          $method = $this->request->getMethod();

          $method = $_POST['_method'] ?? $method;

          foreach ($this->routes as $route) {

               if ($uri == $route['uri'] && strtoupper($method) == $route['method']) {

                    if($route['middleware']){
                         Middleware::resolve($route['middleware']);
                    }

                    $action = $route['action'] ?? false;

                    if($action == false){
                         throw \App\Exceptions\RouteException::notFound();
                    }

                    if(is_string($action)){
                         return $this->renderView($action);
                    }

                    return call_user_func($action);
               }
          }
     }

     private function add(string $uri, callable $callback, string $method): Router
     {
          $this->routes[] = [
               'uri' => $uri,
               'action' => $callback,
               'method' => $method,
               'middleware' => null
          ];

          return $this;
     }

     public function get(string $uri, callable $callback): Router
     {
          return $this->add($uri, $callback, 'GET');
     }

     public function post(string $uri, callable $callback): Router
     {
          return $this->add($uri, $callback, 'POST');
     }

     public function delete(string $uri, callable $callback): Router
     {
          return $this->add($uri, $callback, 'DELETE');
     }

     public function patch(string $uri, callable $callback): Router
     {
          return $this->add($uri, $callback, 'PATCH');
     }

     public function only(string $key)
     {
          $this->routes[array_key_last($this->routes)]['middleware'] = $key;
     }

     public function renderView(string $view)
     {
          $layout = $this->layout();
          include_once APP_ROOT . "/views/$view.view.php";
     }

     protected function layout(){

     }

     protected static function abort(int $status_code = null)
     {
          switch ($status_code) {
               case 404:
                    http_response_code(404);
                    require APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . '404.view.php';
                    break;
               case 403:
                    http_response_code(403);
                    require APP_ROOT . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . '403.view.php';
                    break;
          }

          die();
     }

     public function getRoutes(): array
     {
          return $this->routes;
     }
}
