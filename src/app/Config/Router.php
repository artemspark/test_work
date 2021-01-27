<?php

namespace TestApi\Config;

class Router
{
    private static array $routes = [];

    public static function post(string $route, string $method)
    {
        self::$routes['post'][$route] = $method;
    }

    public static function get(string $route, string $method)
    {
        self::$routes['get'][$route] = $method;
    }

    public static function put(string $route, string $method)
    {
        self::$routes['put'][$route] = $method;
    }

    public static function delete(string $route, string $method)
    {
        self::$routes['delete'][$route] = $method;
    }

    public static function run()
    {
        $variables = [];
        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

        $currentRoute = trim($_GET['route'], '/');
        $currentRouteArray = explode('/', $currentRoute);
        $currentRouteLength = count($currentRouteArray);

        foreach (self::$routes as $method => $routes) {

            // если тип запроса не совпадает
            if ($requestMethod !== $method) {
                continue;
            }

            foreach ($routes as $route => $method) {
                $route = trim($route, '/');
                $routeArray = explode('/', $route);

                // если текущий маршрут не равен по длине, пропускаем
                if (count($routeArray) != $currentRouteLength) continue;

                foreach ($currentRouteArray as $currentRouteArrayKey => $currentRouteArrayPiece) {
                    $routeArrayPiece = $routeArray[$currentRouteArrayKey];

                    //Если есть подстановка переменной - записываем ее
                    if (strpos($routeArrayPiece, ':') !== false) {
                        $variables[str_replace(':', '', $routeArrayPiece)] = $currentRouteArrayPiece;
                    } elseif ($routeArrayPiece !== $currentRouteArrayPiece) {
                        break 2;
                    }
                }

                //Вызываем нужный метод
                list($methodClass, $methodMethod) = explode('@', $method);

                if (!class_exists($methodClass)) {
                    throw new \Exception("Route error. Class ($methodClass) not found");
                }
                if (!method_exists($methodClass, $methodMethod)) {
                    throw new \Exception("Route error. Method ($methodMethod) not found");
                }

                $request = self::prepareRequest();
                $methodClass::$methodMethod(array_merge($variables, $request));

                return;
            }
        }
        throw new \Exception("Unable to find route.");
    }

    private static function prepareRequest()
    {
        
        $variables = array_merge($_GET, $_POST, $_FILES);
        unset($variables['route']);
        return $variables;
    }
}
