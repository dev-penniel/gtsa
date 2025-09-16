<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourismBusiness extends Model
{

    protected $fillable = [
        // Basic Info
        'name',
        'slug',
        'description',
        'business_type',
        'category',
        'is_featured',
        'status',
        'date_registered',

        'services',
        'experience',
        'amenities',

        // Contact
        'phone',
        'email',
        'website',
        'whatsapp',

        // Location
        'country',
        'city',
        'address',
        'latitude',
        'longitude',

        // Media
        'cover_image',
        'images',
        'video_url',

        // Services & Amenities
        'services',
        'parking',
        'pool',
        'bar',
        'restaurant',
        'pet_friendly',

        // Operating Hours
        'operating_hours',

        // Pricing
        'price_range',
        'currency',
        'accepts_credit_card',

        // Ratings
        'average_rating',
        'review_count',

        // Social Media
        'facebook',
        'instagram',
        'tiktok',

        // Owner
        'owner_name',
        'owner_email',
    ];


    protected $casts = [
        'category' => 'array',
        'images' => 'array',
        'services' => 'array',
        'amenities' => 'array',
        'experience' => 'array',
        'operating_hours' => 'array',
        'is_featured' => 'boolean',
        'parking' => 'boolean',
        'pool' => 'boolean',
        'bar' => 'boolean',
        'restaurant' => 'boolean',
        'pet_friendly' => 'boolean',
        'accepts_credit_card' => 'boolean',
        'date_registered' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

}
