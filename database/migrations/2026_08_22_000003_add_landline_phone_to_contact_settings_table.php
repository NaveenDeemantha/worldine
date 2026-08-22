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
        Schema::table('contact_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('contact_settings', 'landline_phone')) {
                $table->string('landline_phone')->nullable()->after('hero_subtitle')->default('+94 11 263 6558');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_settings', function (Blueprint $table) {
            if (Schema::hasColumn('contact_settings', 'landline_phone')) {
                $table->dropColumn('landline_phone');
            }
        });
    }
};
