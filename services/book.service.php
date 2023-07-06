<?php

class BookService extends Service
{
    public function create($data)
    {
        $now = new DateTime();
        $this->db->prepare("
            INSERT INTO books
                (user_id, title, author, published_year, price, created_at, updated_at)
            VALUES
                (:user_id, :title, :author, :published_year, :price, :created_at, :updated_at)
        ")->execute([
            ...$data,
            "created_at" => $now->format("Y-m-d H:i:s.v"),
            "updated_at" => $now->format("Y-m-d H:i:s.v")
        ]);
        return new Book([
            ...$data,
            "id" => $this->db->lastInsertId(),
            "created_at" => $now,
            "updated_at" => $now
        ]);
    }

    public function findById(int $id, ?int $userId = null)
    {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE id = {$id} LIMIT 1");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $row = $stmt->fetch();
        if (!$row) {
            throw new NotFound("Book not found.");
        }
        if (isset($userId) && $row["user_id"] !== $userId) {
            throw new Forbidden();
        }
        return new Book([
            ...$row,
            "created_at" => DateTime::createFromFormat("Y-m-d H:i:s.v", $row["created_at"]),
            "updated_at" => DateTime::createFromFormat("Y-m-d H:i:s.v", $row["created_at"])
        ]);
    }

    public function find(array $query, $limit = 100, $offset = 0)
    {
        $whereStr = count($query) > 0 ? join(" AND ", array_map(fn ($key) => "{$key} = ?", array_keys($query))) : "1=1";
        $stmt = $this->db->prepare("SELECT * FROM books WHERE {$whereStr} LIMIT {$offset}, {$limit}");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute(array_values($query));
        $books = [];
        while ($row = $stmt->fetch()) {
            $book = new Book([
                ...$row,
                "created_at" => DateTime::createFromFormat("Y-m-d H:i:s.v", $row["created_at"]),
                "updated_at" => DateTime::createFromFormat("Y-m-d H:i:s.v", $row["created_at"])
            ]);
            array_push($books, $book);
        }
        return $books;
    }

    public function deleteById(int $id, ?int $userId = null)
    {
        $book = $this->findById($id, $userId);
        $this->db->exec("DELETE FROM books WHERE id = {$id}");
        return $book;
    }

    public function updateById(int $id, $data, ?int $userId = null)
    {
        $book = $this->findById($id, $userId);
        $now = new DateTime();
        foreach ($data as $key => $value) {
            $book->{$key} = $value;
        }
        $data["updated_at"] = $now->format("Y-m-d H:i:s.v");
        $book->updated_at = $now;
        $setStr = join(", ", array_map(fn ($key) => "{$key} = ?", array_keys($data)));
        $this->db->prepare("UPDATE books SET " . $setStr . " WHERE id = {$id}")
            ->execute(array_values($data));
        return $book;
    }
}
