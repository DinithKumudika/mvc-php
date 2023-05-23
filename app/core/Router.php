<?php

namespace App\Core;

class Router
{
     public Request $request;
     public Response $response;

     /**
      * returns an array of routes from routing table
      * @var array
      */
     protected array $routes = [];

     /**
      * returns an array of route parameters
      * @var array
      */
     protected array $params = [];


     public function __construct(Request $request, Response $response)
     {
          $this->request = $request;
          $this->response = $response;
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
                         $this->response->setStatusCode(404);
                         //TODO: change later
                         return $this->renderView('_404');
                         //throw \App\Exceptions\RouteException::notFound();
                    }

                    if(is_string($action)){
                         return $this->renderView($action);
                    }

                    return call_user_func($action);
               }
          }
     }

     public function renderView(string $view, array $params =[])
     {
          $layoutContent = $this->layout();
          $viewContent = $this->onlyView($view, $params);
          return str_replace('{{body}}', $viewContent, $layoutContent);
     }

     protected function layout(){
          ob_start();
          include_once Application::$ROOT_DIR . "/views/layouts/main.php";
          return ob_get_clean();
     }

     protected function onlyView($view, array $params)
     {
          ob_start();
          include_once Application::$ROOT_DIR . "/views/$view.view.php";
          return ob_get_clean();
     }

     /**
      * Add a route to the routing table
      *
      * @param string $uri
      * @param callable $callback
      * @param string $method
      * @return Router
      */
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

     /**
      * Add a route as a get route
      */
     public function get(string $uri, callable $callback): Router
     {
          return $this->add($uri, $callback, 'GET');
     }

     /**
      * Add a route as a post route
      */
     public function post(string $uri, callable $callback): Router
     {
          return $this->add($uri, $callback, 'POST');
     }

     /**
      * Add a route as a delete route
      */
     public function delete(string $uri, callable $callback): Router
     {
          return $this->add($uri, $callback, 'DELETE');
     }

     /**
      * Add a route as a patch route
      */
     public function patch(string $uri, callable $callback): Router
     {
          return $this->add($uri, $callback, 'PATCH');
     }

     /**
      * declare middleware associated with the route
      */
     public function only(string $key)
     {
          $this->routes[array_key_last($this->routes)]['middleware'] = $key;
     }

     /**
      * get all registered routes in the router
      */
     public function getRoutes(): array
     {
          return $this->routes;
     }
}
