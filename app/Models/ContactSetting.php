<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_badge',
        'hero_title',
        'hero_subtitle',
        'primary_phone',
        'outbound_phone',
        'inbound_phone',
        'primary_email',
        'tours_email',
        'office_address',
        'office_hours_weekday',
        'office_hours_saturday',
        'office_hours_sunday',
        'google_maps_url',
        'form_title',
        'form_subtitle',
        'notification_email',
        'notification_cc_emails',
    ];
}
