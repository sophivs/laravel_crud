<?php

namespace App\Domain\Models;

class Task
{
    public function __construct(
        public ?int $id,
        public string $title,
        public string $status,
        public int $user_id,
        public int $category_id
    ) {}

    public function isOwnedBy(int $userId): bool
    {
        return $this->user_id === $userId;
    }
}
