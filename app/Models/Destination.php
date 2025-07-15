<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'location', 'province', 'city', 'address',
        'best_time_to_visit', 'rating', 'image_url', 'category', 'tags',
        'latitude', 'longitude', 'is_featured'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean'
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}