<?php


class Router
{
    /**
     * Contain routes
     *
     * @var array
     */
    private $routes;

    /**
     * Get Routes path from config file
     *
     * Router constructor.
     */
    public function __construct()
    {
        $routesPath = ROOT . '/routes/routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * Get current URI
     *
     * @return string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {

            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    /**
     *  Get Connection from URI to action in Controllers
     */
    public function run()
    {
        $uri = $this->getURI();

        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $action = $this->getControllerAndAction($internalRoute);

                // Invoke receive method in received Controller
                $result = call_user_func_array(array($action[0], $action[1]), $action[2]);

                if ($result)
                    break;
            }
        }
    }

    /**
     * Get Controller and action with parameters from Inside path
     *
     * @param $internalRoute
     * @return array
     */
    public function getControllerAndAction($internalRoute)
    {
        $segments = explode('/', $internalRoute);
        $controllerName = ucfirst(array_shift($segments)) . 'Controller';
        $actionName = 'action' . ucfirst(array_shift($segments));
        // connect file Controller Class
        $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
        file_exists($controllerFile) ? include_once($controllerFile) : null;

        // Create Object, get action -> method
        $controllerObject = new $controllerName();

        return array($controllerObject, $actionName, $segments);
    }
}