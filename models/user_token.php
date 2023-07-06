<?php

class UserToken extends Model {
    public ?int $id;
    public ?int $user_id;
    public ?string $token;
    public ?DateTimeInterface $expires_at;
    public ?DateTimeInterface $created_at;
}
