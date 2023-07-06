<?php

$routes = [
    [
        "method" => "GET",
        "path" => "/",
        "action" => "WebController::renderHomePage",
        "middlewares" => ["LoggedMiddleware"],
    ],
    [
        "method" => "GET",
        "path" => "/login",
        "action" => "WebController::renderLoginPage",
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
