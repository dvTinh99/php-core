<?php

declare(strict_types=1);
class Router
{
    private array $routes = [];
    private $currentIndex;

    public function get(string $path, array $controller) {
        return $this->add('GET', $path, $controller);
    }

    public function post(string $path, array $controller) {
        return $this->add('POST', $path, $controller);
    }

    public function put(string $path, array $controller) {
        return $this->add('PUT', $path, $controller);
    }

    public function delete(string $path, array $controller) {
        return $this->add('DELETE', $path, $controller);
    }
    public function add(string $method, string $path, array $controller)
    {
        $path = $this->normalizePath($path);
        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => [],
            'name' => null
        ];

        $this->currentIndex = count($this->routes) - 1;
        return $this;
    }

    public function middleware(array $middlewares) {
        $this->routes[$this->currentIndex]['middlewares'] = $middlewares;
    }

    private function normalizePath(string $path): string
    {
        $path = trim($path, '/');
        $path = "/$path/";
        $path = preg_replace('#[/]{2,}#', '/', $path);
        return $path;
    }
    public function dispatch(string $path)
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($_SERVER['REQUEST_METHOD']);

        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$route['path']}$#", $path) ||
                $route['method'] !== $method
            ) {
                continue;
            }

            $middlewares = $route['middlewares'];

            foreach($middlewares as $middleware) {
                $md = new $middleware;
                $rs = $md->run();

                if (!$rs) {
                    $md->fallBack();
                    die();
                };
            }

            [$class, $function] = $route['controller'];

            $controllerInstance = new $class;

            $controllerInstance->{$function}();

        }
    }
}
