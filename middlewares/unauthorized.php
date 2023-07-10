<?php

class UnauthorizedMiddleware extends Middleware
{
    public function __construct(private UserService $userService)
    {
    }

    public function canActivate(HttpRequest $req): bool
    {
        if (isset($req->user)) {
            return false;
        }
        if (array_key_exists("remember_token", $req->cookie)) {
            $user = $this->userService->loginByToken($req->cookie["remember_token"]);
            if (isset($user)) {
                $_SESSION["user"] = $user;
                return false;
            }
        }
        return true;
    }

    public function handleInactivate(HttpRequest $req, HttpResponse $res)
    {
        return $res->redirect("/");
    }
}
