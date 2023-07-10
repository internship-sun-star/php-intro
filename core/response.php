<?php

class HttpResponse
{
    private int $status = 200;
    private $body = null;
    private array $headers = [];
    private array $view = [];
    private bool $needRedirect = false;

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function setStatus(int $status)
    {
        $this->status = $status;
        return $this;
    }

    public function setCookie(string $key, string $value = "", $expires = 0, $path = "", $domain = "", $secure = false, $httpOnly = false)
    {
        setcookie($key, $value, $expires, $path, $domain, $secure, $httpOnly);
        return $this;
    }

    public function removeCookie(string $key)
    {
        setcookie($key, null, -1);
        return $this;
    }

    public function deleteUser()
    {
        session_unset();
        session_destroy();
        return $this;
    }

    public function setUser(User $user)
    {
        $_SESSION["user"] = $user;
        return $this;
    }

    public function json($body)
    {
        $this->headers["Content-Type"] = "application/json";
        $this->body = json_encode($body);
        return $this;
    }

    public function redirect(string $url)
    {
        $url = str_starts_with($url, "/") ? substr($url, 1) : $url;
        $this->headers["Location"] = "http://localhost/php-intro/{$url}";
        $this->status = 303;
        $this->needRedirect = true;
        return $this;
    }

    public function render(string $view, array $args = [])
    {
        $this->view = [
            "template" => realpath($view),
            "args" => $args
        ];
        return $this;
    }

    public function send()
    {
        if (isset($this->headers)) {
            foreach ($this->headers as $key => $value) {
                header("{$key}: {$value}");
            }
        }
        $status = isset($this->status) ? $this->status : 200;
        http_response_code($status);
        if ($this->needRedirect) {
            return;
        }
        if (!empty($this->view)) {
            extract($this->view["args"]);
            return require($this->view["template"]);
        }
        $isJsonBody = gettype($this->body) === "array" or gettype($this->body) === "object";
        if ($isJsonBody) {
            echo json_encode($this->body);
            return;
        }
        echo $this->body;
    }
}
