<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'subtitle',
        'description',
        'image',
        'badge',
        'is_glimpse',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_glimpse' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function packages(): HasMany
    {
        return $this->hasMany(TourPackage::class)->where('is_active', true)->orderBy('sort_order');
    }
}
