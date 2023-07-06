<?php

class UserService extends Service
{
    public function login(string $username, string $password)
    {
        $user = $this->findByUsername($username);
        if (!$user || !password_verify($password, $user->password)) {
            throw new Unauthorized("Username or password is not correct.");
        }
        return $user;
    }

    public function loginByToken(string $token)
    {
        $stmt = $this->db->prepare("
            SELECT users.id, users.full_name, users.username, users.password 
            FROM users JOIN user_tokens ON users.id = user_tokens.user_id 
            WHERE expires_at >= :now AND token = :token
        ");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute([
            "now" => date('Y-m-d H:i:s.v'),
            "token" => $token
        ]);
        $row = $stmt->fetch();
        return !$row ? null : new User($row);
    }

    public function findByUsername(string $username)
    {
        $stmt = $this->db->prepare("SELECT id, full_name, username, password FROM users WHERE username = :username");
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute(["username" => $username]);
        $row = $stmt->fetch();
        return !$row ? null : new User($row);
    }

    public function register($args)
    {
        try {
            $user = array_merge([], $args);
            $now = new DateTime();
            $user["created_at"] = $user["updated_at"] = $now;
            $user["password"] = password_hash($user["password"], PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (full_name, username, password, created_at, updated_at) VALUES (:full_name, :username, :password, :created_at, :updated_at)";
            $this->db->prepare($sql)->execute([
                ...$user,
                "created_at" => $now->format("Y-m-d H:i:s.v"),
                "updated_at" => $now->format("Y-m-d H:i:s.v"),
            ]);

            return new User([
                "id" => intval($this->db->lastInsertId()),
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
