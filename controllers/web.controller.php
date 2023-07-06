<?php

class WebController
{
    public function renderLoginPage(HttpRequest $req, HttpResponse $res)
    {
        return $res->render("views/login.view.php");
    }

    public function renderHomePage(HttpRequest $req, HttpResponse $res)
    {
        return $res->render("views/home.view.php");
    }
}
