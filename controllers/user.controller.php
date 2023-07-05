<?php

class UserController
{
    private UserService $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    public function register(HttpRequest $req)
    {
        $validator = new RequestValidator([
            "full_name" => "required|type=string",
            "username" => "required|type=string",
            "password" => "required|type=string"
        ]);
        $vBody = $validator->validate($req->body);
        $user = $this->service->register($vBody);
        $res = new HttpResponse();
        return $res->setStatus(201)->json($user);
    }

    public function login(HttpRequest $req)
    {
        $validator = new RequestValidator([
            "username" => "required|type=string",
            "password" => "required|type=string",
        ]);
        $vBody = $validator->validate($req->body);
        $user = $this->service->login($vBody["username"], $vBody["password"]);
        $res = new HttpResponse();
        return $res->setUser($user);
    }

    public function logout(HttpRequest $req)
    {
        $req->deleteUser();
        $res = new HttpResponse();
        return $res->setStatus(204);
    }

    public function renderLoginPage()
    {
        $res = new HttpResponse();
        return $res->render("views/login.view.php");
    }

    public function renderHomePage()
    {
        $res = new HttpResponse();
        return $res->render("views/home.view.php");
    }
}
