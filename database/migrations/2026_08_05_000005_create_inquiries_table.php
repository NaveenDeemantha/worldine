<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('reference_id')->unique();
            $table->enum('type', ['package_inquiry', 'general_contact'])->default('general_contact');
            $table->string('customer_name');
            $table->string('email');
            $table->string('phone');
            $table->foreignId('tour_package_id')->nullable()->constrained('tour_packages')->nullOnDelete();
            $table->string('package_title')->nullable();
            $table->string('travel_date')->nullable();
            $table->integer('guests')->default(1);
            $table->string('inquiry_type')->nullable();
            $table->string('destination_name')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
