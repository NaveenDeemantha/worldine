<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_id',
        'type',
        'customer_name',
        'email',
        'phone',
        'tour_package_id',
        'package_title',
        'travel_date',
        'guests',
        'inquiry_type',
        'destination_name',
        'message',
        'status',
    ];

    protected $casts = [
        'guests' => 'integer',
    ];

    public function tourPackage(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class, 'tour_package_id');
    }
}
