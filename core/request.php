<?php

class HttpRequest
{
    public string $method;
    public string $uri;
    public ?array $params;
    public ?array $query;
    public $body;
    public array $session;
    public array $cookie;
    public ?User $user;
    public array $args;

    public function __construct($properties = [])
    {
        foreach ($properties as $key => $value) {
            $this->{$key} = $value;
        }
        $this->session = $_SESSION;
        $this->cookie = $_COOKIE;
        $this->user = isset($this->session["user"]) ? $this->session["user"] : null;
        $this->args = isset($this->session["args"]) ? $this->session["args"] : [];
    }
}

function extractBody()
{
    $method = $_SERVER["REQUEST_METHOD"];
    if ($method === "POST" or $method === "PUT" or $method === "PATCH") {
        $contentType = $_SERVER["HTTP_CONTENT_TYPE"] ?? $_SERVER['CONTENT_TYPE'];
        $rawBody = file_get_contents('php://input');

        if (str_contains($contentType, "application/json")) {
            return json_decode($rawBody, true);
        }

        if (str_contains($contentType, "application/x-www-form-urlencoded")) {
            $body = [];
            parse_str($rawBody, $body);
            return $body;
        }

        if (str_contains($contentType, "multipart/form-data") && $method === "POST") {
            return $_POST;
        }
    }
    return null;
}

function extractQuery()
{
    $query = [];
    parse_str($_SERVER['QUERY_STRING'], $query);
    return $query;
}

function extractParams(string $uri, string $pathPattern)
{
    $uriParts = explode("/", $uri);
    $pathParts = explode("/", $pathPattern);
    if (count($uriParts) !== count($pathParts)) {
        return null;
    }
    $params = [];
    for ($i = 0; $i < count($uriParts); ++$i) {
        if (preg_match("/^\{.+\}$/", $pathParts[$i])) {
            $paramName = substr($pathParts[$i], 1, -1);
            $params[$paramName] = $uriParts[$i];
        } else if ($uriParts[$i] !== $pathParts[$i]) {
            return null;
        }
    }
    return $params;
}
