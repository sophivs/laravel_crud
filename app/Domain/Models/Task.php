<?php

namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'status', 'user_id', 'category_id'];

    public function isOwnedBy(int $userId): bool
    {
        return $this->user_id === $userId;
    }
}
