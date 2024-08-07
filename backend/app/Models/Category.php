<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];
    
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'category_tasks');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
