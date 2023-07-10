<?php

class UserController
{
    public function __construct(private UserService $userService, private UserTokenService $userTokenService)
    {
    }

    public function register(HttpRequest $req, HttpResponse $res)
    {
        $validator = new RequestValidator([
            "full_name" => "required|type=string",
            "username" => "required|type=string",
            "password" => "required|type=string"
        ]);
        $vBody = $validator->validate($req->body);
        $user = $this->userService->register($vBody);
        return $res->setStatus(201)->json($user);
    }

    public function login(HttpRequest $req, HttpResponse $res)
    {
        $validator = new RequestValidator([
            "username" => "required|type=string",
            "password" => "required|type=string",
            "remember" => "required|type=boolean"
        ]);
        $vBody = $validator->validate($req->body);
        $user = $this->userService->login($vBody["username"], $vBody["password"]);
        $rememberToken = $vBody["remember"] ? $this->userTokenService->create($user) : null;
        if (isset($rememberToken)) {
            $res->setCookie("remember_token", $rememberToken->token, $rememberToken->expires_at->getTimestamp());
        }
        return $res->setUser($user);
    }

    public function logout(HttpRequest $req, HttpResponse $res)
    {
        if (isset($req->cookie["remember_token"])) {
            $this->userTokenService->delete($req->cookie["remember_token"]);
            $res->removeCookie("remember_token");
        }
        return $res->deleteUser()->setStatus(204);
    }
}
