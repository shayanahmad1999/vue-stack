<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'image'

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
