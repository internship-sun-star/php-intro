<?php

abstract class Middleware
{
    public abstract function canActivate(HttpRequest $req): bool;

    public function handleInactivate(HttpRequest $req, HttpResponse $res)
    {
        return $res->setStatus(403)->json([
            "code" => 403,
            "message" => "Forbidden"
        ]);
    }
}
