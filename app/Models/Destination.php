<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    protected $fillable = ['name', 'accommodation', 'itinerary_id'];

    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(Itinerary::class);
    }

    public function toVisits(): HasMany
    {
        return $this->hasMany(ToVisit::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function dishes(): HasMany
    {
        return $this->hasMany(Dishes::class);
    }
}
