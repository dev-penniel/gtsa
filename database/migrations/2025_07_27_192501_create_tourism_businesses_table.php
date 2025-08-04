<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tourism_businesses', function (Blueprint $table) {
            
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('business_type'); // e.g., Lodge, Travel Agency
            $table->json('category')->nullable(); // store as array: ["Adventure", "Hiking"]
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['pending', 'active', 'suspended'])->default('pending');
            $table->timestamp('date_registered')->nullable();

            // Contact
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('whatsapp')->nullable();

            // Location
            $table->string('country');
            $table->string('city');
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();

            // Media
            $table->string('cover_image');
            $table->json('images')->nullable(); // array of URLs
            $table->string('video_url')->nullable();

            // Services & Amenities
            $table->json('services')->nullable(); // e.g., ["Free WiFi", "Guided Hiking"]
            $table->boolean('parking')->default(false);
            $table->boolean('pool')->default(false);
            $table->boolean('bar')->default(false);
            $table->boolean('restaurant')->default(false);
            $table->boolean('pet_friendly')->default(false);

            // Operating Hours
            $table->json('operating_hours')->nullable(); // {"monday": "08:00-22:00", ...}

            // Pricing
            $table->string('price_range')->nullable(); // e.g., M500 - M1000
            $table->string('currency')->default('LSL');
            $table->boolean('accepts_credit_card')->default(true);

            // Ratings
            $table->float('average_rating')->default(0);
            $table->integer('review_count')->default(0);

            // Social Media
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();

            // Owner Info
            $table->string('owner_name')->nullable();
            $table->string('owner_email')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourism_businesses');
    }
};
