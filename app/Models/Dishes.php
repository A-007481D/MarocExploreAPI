<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dishes extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'destination_id'];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
