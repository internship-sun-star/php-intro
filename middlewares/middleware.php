<?php

abstract class Middleware {
    public abstract function canActivate(HttpRequest $req): bool;

    public function handleInactivate(HttpRequest $req) {
        $exception = new Forbidden();
        return $exception->toResponse();
    }
}
