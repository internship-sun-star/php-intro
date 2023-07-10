<?php

class UserTokenService extends Service
{
    public function create(User $user)
    {
        $token = $this->generateToken();
        $createdAt = new DateTime();
        $expiresAt = $createdAt->add(new DateInterval("P1M"));

        $this->db->prepare("INSERT INTO user_tokens (user_id, token, expires_at, created_at) VALUES (:user_id, :token, :expires_at, :created_at)")
            ->execute([
                "user_id" => $user->id,
                "token" => $token,
                "created_at" => $createdAt->format("Y-m-d H:i:s.v"),
                "expires_at" => $expiresAt->format("Y-m-d H:i:s.v")
            ]);

        return new UserToken([
            "id" => intval($this->db->lastInsertId()),
            "user_id" => $user->id,
            "token" => $token,
            "created_at" => $createdAt,
            "expires_at" => $expiresAt
        ]);
    }

    private function generateToken(int $nByte = 20)
    {
        $bytes = random_bytes($nByte);
        return bin2hex($bytes);
    }

    public function delete(string $token)
    {
        return $this->db->prepare("DELETE FROM user_tokens WHERE token = :token")->execute([ "token" => $token ]);
    }
}
