<?php

class UserService
{
    public function login(string $username, string $password)
    {
        $connection = DBConnection::getInstance();
        $stmt = $connection->prepare("SELECT id, full_name, username, password FROM users WHERE username = :username");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute([ "username" => $username ]);
        $row = $stmt->fetch();
        if (!$row || !password_verify($password, $row["password"])) {
            throw new Unauthorized("Username or password is not correct.");
        }
        return new User($row);
    }

    public function register($args)
    {
        try {
            $user = array_merge([], $args);
            $now = new DateTimeImmutable();
            $user["created_at"] = $user["updated_at"] = $now;
            $user["password"] = password_hash($user["password"], PASSWORD_DEFAULT);

            $connection = DBConnection::getInstance();
            $sql = "INSERT INTO users (full_name, username, password, created_at, updated_at) VALUES (:full_name, :username, :password, :created_at, :updated_at)";
            $connection->prepare($sql)->execute([
                ...$user,
                "created_at" => $now->format("Y-m-d H:i:s.v"),
                "updated_at" => $now->format("Y-m-d H:i:s.v"),
            ]);

            return new User([
                "id" => intval($connection->lastInsertId()),
                ...$user
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() === "23000") {
                throw new Conflict("Username has been existed.");
            }
            throw $e;
        }
    }
}
