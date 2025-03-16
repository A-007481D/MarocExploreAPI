<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Itinerary extends Model
{
    protected $fillable = ['title', 'duration', 'image', 'user_id', 'category_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function destinations(): HasMany
    {
        return $this->hasMany(Destination::class);
    }

    public function savers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'itinerary_user')->withTimestamps();
    }
}
