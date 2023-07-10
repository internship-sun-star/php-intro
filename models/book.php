<?php

class Book extends Model
{
    public ?int $id;
    public ?string $title;
    public ?string $author;
    public ?int $published_year;
    public ?float $price;
    public ?int $user_id;
    public ?DateTimeInterface $created_at;
    public ?DateTimeInterface $updated_at;
}
