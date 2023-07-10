<?php

require_once __DIR__ . "/bootstrap.php";
require_once __DIR__ . "/providers.php";
require_once __DIR__ . "/routes.php";

date_default_timezone_set("Asia/Ho_Chi_Minh");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function handleRequest(): HttpResponse
{
    global $routes;
    global $providers;

    $isMatch = false;
    $uri = str_replace("/php-intro", "", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
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
            $response = new HttpResponse();

            // Middleware
            if (isset($route["middlewares"])) {
                foreach ($route["middlewares"] as $class) {
                    $isActive = $providers["middlewares"][$class]->canActivate($request);
                    if (!$isActive) {
                        return $providers["middlewares"][$class]->handleInactivate($request, $response);
                    }
                }
            }

            // Controller
            [$ctrlClass, $action] = explode("::", $route["action"]);
            return $providers["controllers"][$ctrlClass]->{$action}($request, $response);
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

handleRequest()->send();
