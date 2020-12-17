<?php

    $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
        $basedir = parse_url($_ENV['APP_URL'], PHP_URL_PATH);
        $r->addRoute('GET', $basedir . '/', 'main@notAllowed');
        $r->addRoute('GET', $basedir . '/peliculas', 'peliculas@getAll');
        $r->addRoute('GET', $basedir . '/peliculas/{id:\d+}', 'peliculas@getById');
        $r->addRoute('GET', $basedir . '/actor', 'actores@getAll');
        $r->addRoute('GET', $basedir . '/actor/{id:\d+}', 'actores@getById');
        $r->addRoute('GET', $basedir . '/director', 'directores@getAll');
        $r->addRoute('GET', $basedir . '/director/{id:\d+}', 'directores@getById');
        $r->addRoute('GET', $basedir . '/criticas', 'critica@getAll');
        $r->addRoute('GET', $basedir . '/peliculas/{id:\d+}/criticas', 'peliculas@criticas');
        $r->addRoute('GET', $basedir . '/criticas/{id:\d+}', 'critica@getById');
        $r->addRoute('POST', $basedir . '/peliculas/{id:\d+}/criticas', 'critica@insert');
        $r->addRoute('PUT', $basedir . '/criticas/{id_critica:\d+}', 'critica@edit');
        $r->addRoute('DELETE', $basedir . '/criticas/{id_critica:\d+}', 'critica@delete');
    });

    //$httpMethod = $_SERVER['REQUEST_METHOD'];
    $metodosPermitidos = ['GET', 'POST', 'PUT', 'DELETE'];
    $httpMethod = strtoupper($_POST['_method']??$_SERVER['REQUEST_METHOD']);
    if(!in_array($httpMethod, $metodosPermitidos)) {
        $httpMethod = 'GET';
    }
    $uri = $_SERVER['REQUEST_URI'];
    if (false !== $pos = strpos($uri, '?')) {
        $uri = substr($uri, 0, $pos);
    }

    $uri = rawurldecode($uri);
    $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

    switch ($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            $controllerName = '\\app\\controllers\\Main';
            $action = 'notFound';
            $controller = new $controllerName();
            $controller->$action();
        break;

        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = $routeInfo[1];
            $controllerName = '\\app\\controllers\\Main';
            $action = 'notAllowed';
            $controller = new $controllerName();
            $controller->$action();
        break;

        case FastRoute\Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $partes = explode('@', $handler);
            $controllerName = '\\app\\controllers\\'.ucfirst($partes[0]);
            $action = $partes[1];
            $controller = new $controllerName();
            $vars = $routeInfo[2];
            $controller->$action($vars);
        break;
      
        
    }