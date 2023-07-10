<?php

class AuthorizedMiddleware extends Middleware
{
    public function __construct(private UserService $userService)
    {
    }

    public function canActivate(HttpRequest $req): bool
    {
        if (isset($req->user)) {
            return true;
        }
        if (isset($req->cookie["remember_token"])) {
            $user = $this->userService->loginByToken($req->cookie["remember_token"]);
            if (isset($user)) {
                $_SESSION["user"] = $user;
            }
            return isset($user);
        }
        return false;
    }

    public function handleInactivate(HttpRequest $req, HttpResponse $res)
    {
        return $res->redirect("/login");
    }
}
