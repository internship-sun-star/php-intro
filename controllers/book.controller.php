<?php

class BookController
{
    public function __construct(private BookService $bookService)
    {
    }

    public function create(HttpRequest $req, HttpResponse $res)
    {
        $validator = new RequestValidator([
            "title" => "required|type=string",
            "author" => "required|type=string",
            "published_year" => "required|type=integer|min=1990",
            "price" => "required|type=double|min=0"
        ]);
        $vBody = $validator->validate($req->body);
        $book = $this->bookService->create([...$vBody, "user_id" => $req->user->id]);
        return $res->setStatus(201)->json($book);
    }

    public function find(HttpRequest $req, HttpResponse $res)
    {
        $validator = new RequestValidator([
            "limit" => "int_str|min=0",
            "offset" => "int_str|min=0",
            "title" => "type=string",
            "author" => "type=string"
        ]);
        $vQuery = $validator->validate($req->query);
        $limit = in_array("limit", $vQuery) ? intval($vQuery["limit"]) : 100;
        $offset = in_array("offset", $vQuery) ? intval($vQuery["offset"]) : 0;
        unset($vQuery["limit"], $vQuery["offset"]);
        $books = $this->bookService->find([...$vQuery, "user_id" => $req->user->id], $limit, $offset);
        return $res->json($books);
    }

    public function findById(HttpRequest $req, HttpResponse $res)
    {
        $validator = new RequestValidator([
            "id" => "required|int_str",
        ]);
        $vParams = $validator->validate($req->params);
        $id = intval($vParams["id"]);
        $book = $this->bookService->findById($id, $req->user->id);
        return $res->json($book);
    }

    public function updateById(HttpRequest $req, HttpResponse $res)
    {
        $validator = new RequestValidator([
            "id" => "required|int_str",
            "title" => "type=string",
            "author" => "type=string",
            "published_year" => "type=integer|min=1990",
            "price" => "type=double|min=0"
        ]);
        $vArgs = $validator->validate([
            "id" => $req->params["id"],
            ...$req->body
        ]);
        $vData = array_slice($vArgs, 1);
        $id = intval($vArgs["id"]);
        $book = $this->bookService->updateById($id, $vData, $req->user->id);
        return $res->json($book);
    }

    public function deleteById(HttpRequest $req, HttpResponse $res)
    {
        $validator = new RequestValidator([
            "id" => "required|int_str",
        ]);
        $vParams = $validator->validate($req->params);
        $id = intval($vParams["id"]);
        $this->bookService->deleteById($id, $req->user->id);
        return $res->setStatus(204);
    }
}
