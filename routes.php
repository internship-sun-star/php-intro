<?php

$routes = [
    [
        "method" => "GET",
        "path" => "/",
        "action" => "WebController::renderHomePage",
        "middlewares" => ["AuthorizedMiddleware"],
    ],
    [
        "method" => "GET",
        "path" => "/login",
        "action" => "WebController::renderLoginPage",
        "middlewares" => ["UnauthorizedMiddleware"],
    ],
    [
        "method" => "POST",
        "path" => "/login",
        "action" => "UserController::login",
        "middlewares" => ["UnauthorizedMiddleware"],
    ],
    [
        "method" => "DELETE",
        "path" => "/logout",
        "action" => "UserController::logout",
        "middlewares" => ["AuthorizedMiddleware"],
    ],
    [
        "method" => "POST",
        "path" => "/users",
        "action" => "UserController::register",
        "middlewares" => ["UnauthorizedMiddleware"],
    ],
    [
        "method" => "POST",
        "path" => "/books",
        "action" => "BookController::create",
        "middlewares" => ["AuthorizedMiddleware"],
    ],
    [
        "method" => "GET",
        "path" => "/books",
        "action" => "BookController::find",
        "middlewares" => ["AuthorizedMiddleware"],
    ],
    [
        "method" => "GET",
        "path" => "/books/{id}",
        "action" => "BookController::findById",
        "middlewares" => ["AuthorizedMiddleware"],
    ],
    [
        "method" => "DELETE",
        "path" => "/books/{id}",
        "action" => "BookController::deleteById",
        "middlewares" => ["AuthorizedMiddleware"],
    ],
    [
        "method" => "PUT",
        "path" => "/books/{id}",
        "action" => "BookController::updateById",
        "middlewares" => ["AuthorizedMiddleware"],
    ]
];
