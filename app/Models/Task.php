<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    public const NOT_STRATTED = 'not_started';
    public const STATUS_PENDING = 'pending';
    public const STATUS_DONE = 'done';


    protected $fillable = ['title', 'todo_list_id', 'status'];

    public function todo_list(): BelongsTo
    {
        return $this->belongsTo(TodoList::class);
    }
}
