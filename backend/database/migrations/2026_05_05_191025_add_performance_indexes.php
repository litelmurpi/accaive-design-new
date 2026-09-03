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
        Schema::table('projects', function (Blueprint $table) {
            $table->index('is_featured');
            $table->index('sort_order');
            $table->index('slug');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->index('sort_order');
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->index('sort_order');
        });

        Schema::table('site_settings', function (Blueprint $table) {
            $table->index('key');
        });

        Schema::table('exhibitions', function (Blueprint $table) {
            $table->index('sort_order');
        });

        Schema::table('press_articles', function (Blueprint $table) {
            $table->index('published_at');
        });

        Schema::table('job_openings', function (Blueprint $table) {
            $table->index('is_active');
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->index('sort_order');
        });

        Schema::table('featured_stories', function (Blueprint $table) {
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['sort_order']);
            $table->dropIndex(['slug']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['sort_order']);
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->dropIndex(['sort_order']);
        });

        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropIndex(['key']);
        });

        Schema::table('exhibitions', function (Blueprint $table) {
            $table->dropIndex(['sort_order']);
        });

        Schema::table('press_articles', function (Blueprint $table) {
            $table->dropIndex(['published_at']);
        });

        Schema::table('job_openings', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('programs', function (Blueprint $table) {
            $table->dropIndex(['sort_order']);
        });

        Schema::table('featured_stories', function (Blueprint $table) {
            $table->dropIndex(['sort_order']);
        });
    }
};
