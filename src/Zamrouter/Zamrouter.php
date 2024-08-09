<?php

namespace src\Zamrouter;

use Exception;

class Zamrouter
{
    protected $routes = [];
    protected $defaultNamespace = '';

    public function setDefaultNamespace($namespace)
    {
        $this->defaultNamespace = $namespace;
    }

    public function get($route, $action)
    {
        $this->routes['GET'][$route] = $action;
    }

    public function post($route, $action)
    {
        $this->routes['POST'][$route] = $action;
    }

    public function start()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // Remove base path if present
        $basePath = '/' . ROUTER;
        if (strpos($requestUri, $basePath) === 0) {
            $requestUri = substr($requestUri, strlen($basePath));
        }

        // Default to '/' if URI is empty
        $requestUri = $requestUri === '' ? '/' : $requestUri;

        if (isset($this->routes[$requestMethod][$requestUri])) {
            $action = $this->routes[$requestMethod][$requestUri];
            $this->dispatch($action);
        } else {
            // Match dynamic routes
            foreach ($this->routes[$requestMethod] as $route => $action) {
                $pattern = preg_replace('/\{[^\}]+\}/', '([^/]+)', $route);
                if (preg_match('#^' . $pattern . '$#', $requestUri, $matches)) {
                    array_shift($matches);
                    $this->dispatch($action, $matches);
                    return;
                }
            }

            throw new Exception('404 Not Found', 404);
        }
    }

    protected function dispatch($action, $params = [])
    {
        if ($this->defaultNamespace) {
            $action = $this->defaultNamespace . '\\' . $action;
        }

        if (is_string($action)) {
            $action = explode('@', $action);
        }

        $controller = new $action[0];
        call_user_func_array([$controller, $action[1]], $params);
    }
}
