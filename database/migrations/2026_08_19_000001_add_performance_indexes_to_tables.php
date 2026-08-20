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
        Schema::table('destinations', function (Blueprint $table) {
            $table->index(['is_active', 'is_glimpse'], 'dest_active_glimpse_idx');
            $table->index(['type', 'is_active'], 'dest_type_active_idx');
        });

        Schema::table('tour_packages', function (Blueprint $table) {
            $table->index(['is_active', 'category'], 'pkg_active_category_idx');
            $table->index(['is_active', 'is_featured', 'sort_order'], 'pkg_active_featured_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropIndex('dest_active_glimpse_idx');
            $table->dropIndex('dest_type_active_idx');
        });

        Schema::table('tour_packages', function (Blueprint $table) {
            $table->dropIndex('pkg_active_category_idx');
            $table->dropIndex('pkg_active_featured_idx');
        });
    }
};
