<?php

class HttpException extends Exception
{
    public function __construct($message, $code = 500)
    {
        $this->message = $message;
        $this->code = $code;
    }

    public function toResponse()
    {
        $res = new HttpResponse();
        return $res->setStatus($this->code)
            ->json([
                "code" => $this->code,
                "message" => $this->message
            ]);
    }
}

class Unauthorized extends HttpException
{
    public function __construct($message = 'Unauthorized')
    {
        parent::__construct($message, 403);
    }
}

class NotFound extends HttpException
{
    public function __construct($message = 'Not Found')
    {
        parent::__construct($message, 404);
    }
}

class UnprocessedEntity extends HttpException
{
    public function __construct($message = 'Unprocessed Entity')
    {
        parent::__construct($message, 422);
    }
}

class Conflict extends HttpException
{
    public function __construct($message = 'Conflict')
    {
        parent::__construct($message, 409);
    }
}

class Forbidden extends HttpException
{
    public function __construct($message = 'Forbidden')
    {
        parent::__construct($message, 403);
    }
}

class BadRequest extends HttpException
{
    public function __construct($message = 'Bad Request')
    {
        parent::__construct($message, 400);
    }
}
