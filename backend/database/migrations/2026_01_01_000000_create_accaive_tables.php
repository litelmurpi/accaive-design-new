<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category');
            $table->string('client')->nullable();
            $table->string('year')->nullable();
            $table->text('description')->nullable();
            $table->string('hero_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('size')->nullable();
            $table->string('span')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('title');
            $table->text('description');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('exhibitions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location')->nullable();
            $table->string('year')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('press_articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('source')->nullable();
            $table->string('url')->nullable();
            $table->date('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('job_openings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('department')->nullable();
            $table->string('location')->nullable();
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->json('features')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('featured_stories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('contact_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('company')->nullable();
            $table->string('budget')->nullable();
            $table->text('message');
            $table->string('status')->default('new');
            $table->timestamps();
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('contact_submissions');
        Schema::dropIfExists('featured_stories');
        Schema::dropIfExists('programs');
        Schema::dropIfExists('job_openings');
        Schema::dropIfExists('press_articles');
        Schema::dropIfExists('exhibitions');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('services');
        Schema::dropIfExists('projects');
    }
};
