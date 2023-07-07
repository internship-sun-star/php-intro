<?php

$db = new DBConnection();

$services = [
    "UserService" => new UserService($db),
    "UserTokenService" => new UserTokenService($db),
    "BookService" => new BookService($db),
];

$controllers = [
    "UserController" => new UserController($services["UserService"], $services["UserTokenService"]),
    "BookController" => new BookController($services["BookService"]),
    "WebController" => new WebController(),
];

$middlewares = [
    "AuthorizedMiddleware" => new AuthorizedMiddleware($services["UserService"]),
    "UnauthorizedMiddleware" => new UnauthorizedMiddleware($services["UserService"]),
];

$providers = [
    "services" => $services,
    "controllers" => $controllers,
    "middlewares" => $middlewares,
];
