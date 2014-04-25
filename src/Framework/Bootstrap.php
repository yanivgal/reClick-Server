<?php

namespace reClick\Framework;

class Bootstrap {

    public function __construct() {
        $this->instantiateRoutes();
    }

    private function instantiateRoutes() {
        $routersPath = $_SERVER['DOCUMENT_ROOT'] . '/reClick/src/Routes/';
        $routersNamespace = 'reClick\\Routes\\';

        // Get all classes from routers directory
        $classes = [];
        foreach (scandir($routersPath) as $value) {
            if (!in_array($value, ['.', '..'])) {
                $classes[] = basename($value, '.php');
            }
        }

        // Filter the classes who are subclasses of 'BaseRouter'
        $routers = array_filter(
            $classes,
            function($class) use ($routersNamespace) {
                return is_subclass_of(
                    $routersNamespace . $class,
                    'reClick\Routes\BaseRouter'
                );
            }
        );

        // Instantiate all router classes
        foreach ($routers as $routerName) {
            $router = $routersNamespace . $routerName;
            if (isset($router)) {
                new $router;
            }
        }
    }
}