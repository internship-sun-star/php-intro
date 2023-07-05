<?php

class User extends Model
{
    public ?int $id;
    public ?string $full_name;
    public ?string $username;
    public ?string $password;
    public ?DateTimeImmutable $created_at;
    public ?DateTimeImmutable $updated_at;

    public function jsonSerialize()
    {
        $res = parent::jsonSerialize();
        unset($res["password"]);
        return $res;
    }
}
