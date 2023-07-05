<?php

require_once __DIR__ . "/bootstrap.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$providers = [
    "controllers" => [
        "UserController" => new UserController(),
    ],
    "middlewares" => [
        "LoggedMiddleware" => new LoggedMiddleware(),
        "UnLoggedMiddleware" => new UnLoggedMiddleware(),
    ],
];

$routes = [
    [
        "method" => "GET",
        "path" => "/",
        "action" => "UserController::renderHomePage",
        "middlewares" => ["LoggedMiddleware"],
    ],
    [
        "method" => "GET",
        "path" => "/login",
        "action" => "UserController::renderLoginPage",
        "middlewares" => ["UnLoggedMiddleware"],
    ],
    [
        "method" => "POST",
        "path" => "/login",
        "action" => "UserController::login",
        "middlewares" => ["UnLoggedMiddleware"],
    ],
    [
        "method" => "DELETE",
        "path" => "/logout",
        "action" => "UserController::logout",
        "middlewares" => ["LoggedMiddleware"],
    ],
    [
        "method" => "POST",
        "path" => "/users",
        "action" => "UserController::register",
        "middlewares" => ["UnLoggedMiddleware"],
    ],
    [
        "method" => "POST",
        "path" => "/books",
        "action" => "BookController::create",
        "middlewares" => ["LoggedMiddleware"],
    ],
    [
        "method" => "GET",
        "path" => "/books",
        "action" => "BookController::find",
        "middlewares" => ["LoggedMiddleware"],
    ],
    [
        "method" => "GET",
        "path" => "/books/{id}",
        "action" => "BookController::findById",
        "middlewares" => ["LoggedMiddleware"],
    ],
    [
        "method" => "DELETE",
        "path" => "/books/{id}",
        "action" => "BookController::deleteById",
        "middlewares" => ["LoggedMiddleware"],
    ],
    [
        "method" => "PUT",
        "path" => "/books/{id}",
        "action" => "BookController::updateById",
        "middlewares" => ["LoggedMiddleware"],
    ]
];

function handleRequest(): HttpResponse
{
    global $routes;
    global $providers;

    $isMatch = false;
    $uri = str_replace("/php-intro", "", $_SERVER['REQUEST_URI']);
    $method = $_SERVER["REQUEST_METHOD"];
    foreach ($routes as $route) {
        try {
            // Parse Request
            if ($method !== $route["method"]) {
                continue;
            }
            $params = extractParams($uri, $route["path"]);
            if (!isset($params)) {
                continue;
            }
            $isMatch = true;
            $request = new HttpRequest([
                "method" => $method,
                "uri"    => $uri,
                "params" => $params,
                "query"  => extractQuery(),
                "body"   => extractBody()
            ]);

            // Middleware
            if (isset($route["middlewares"])) {
                foreach ($route["middlewares"] as $class) {
                    $isActive = $providers["middlewares"][$class]->canActivate($request);
                    if (!$isActive) {
                        return $providers["middlewares"][$class]->handleInactivate($request);
                    }
                }
            }

            // Controller
            [$ctrlClass, $action] = explode("::", $route["action"]);
            return $providers["controllers"][$ctrlClass]->{$action}($request);
        } catch (Exception $e) {
            $httpException = $e instanceof HttpException ? $e : new HttpException($e->getMessage(), 500);
            return $httpException->toResponse();
        }
    }

    if (!$isMatch) {
        $httpException = new NotFound();
        return $httpException->toResponse();
    }
}

$response = handleRequest();
$response->send();
