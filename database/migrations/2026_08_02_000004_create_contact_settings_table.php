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
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_badge')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('outbound_phone')->nullable();
            $table->string('inbound_phone')->nullable();
            $table->string('primary_email')->nullable();
            $table->string('tours_email')->nullable();
            $table->string('office_address')->nullable();
            $table->string('office_hours_weekday')->nullable();
            $table->string('office_hours_saturday')->nullable();
            $table->string('office_hours_sunday')->nullable();
            $table->text('google_maps_url')->nullable();
            $table->string('form_title')->nullable();
            $table->text('form_subtitle')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_settings');
    }
};
