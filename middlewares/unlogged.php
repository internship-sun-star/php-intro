<?php

class UnLoggedMiddleware extends Middleware {
    public function canActivate(HttpRequest $req): bool
    {
        return !isset($req->user);
    }

    public function handleInactivate(HttpRequest $req)
    {
        $response = new HttpResponse();
        return $response->redirect("/");
    }
}
