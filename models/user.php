<?php

class User extends Model
{
    public ?int $id;
    public ?string $full_name;
    public ?string $username;
    public ?string $password;
    public ?DateTimeInterface $created_at;
    public ?DateTimeInterface $updated_at;

    public function jsonSerialize()
    {
        $res = parent::jsonSerialize();
        unset($res["password"]);
        return $res;
    }
}
