<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasUuids, HasFactory;

    protected $dates = [
        'published_at',
    ];

    protected $orderable = [
        'id',
        'title',
        'published_at'
    ];

    protected $filterable = [
        'title',
        'status',
        'published_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'published_at',
        'featured_image',
        'status',
        'views',
        'likes',
    ];

    public function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function Tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
