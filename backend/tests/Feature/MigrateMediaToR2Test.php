<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Project;
use App\Models\SiteSetting;

class MigrateMediaToR2Test extends TestCase
{
    use RefreshDatabase;

    public function test_migrate_copies_files_from_public_to_s3()
    {
        Storage::fake('public');
        Storage::fake('s3');

        Storage::disk('public')->put('projects/hero/sample.jpg', 'dummy-hero-content');
        Storage::disk('public')->put('team/member.jpg', 'dummy-team-content');

        $this->artisan('media:migrate-to-r2')
            ->assertExitCode(0);

        Storage::disk('s3')->assertExists('projects/hero/sample.jpg');
        Storage::disk('s3')->assertExists('team/member.jpg');
        $this->assertEquals('dummy-hero-content', Storage::disk('s3')->get('projects/hero/sample.jpg'));
    }

    public function test_migrate_skips_existing_files_without_force()
    {
        Storage::fake('public');
        Storage::fake('s3');

        Storage::disk('public')->put('services/photo.jpg', 'new-content');
        Storage::disk('s3')->put('services/photo.jpg', 'original-content');

        $this->artisan('media:migrate-to-r2')
            ->assertExitCode(0);

        $this->assertEquals('original-content', Storage::disk('s3')->get('services/photo.jpg'));
    }

    public function test_migrate_force_overwrites_existing_files()
    {
        Storage::fake('public');
        Storage::fake('s3');

        Storage::disk('public')->put('services/photo.jpg', 'updated-content');
        Storage::disk('s3')->put('services/photo.jpg', 'original-content');

        $this->artisan('media:migrate-to-r2', ['--force' => true])
            ->assertExitCode(0);

        $this->assertEquals('updated-content', Storage::disk('s3')->get('services/photo.jpg'));
    }

    public function test_dry_run_does_not_copy_files()
    {
        Storage::fake('public');
        Storage::fake('s3');

        Storage::disk('public')->put('about/hero.jpg', 'about-content');

        $this->artisan('media:migrate-to-r2', ['--dry-run' => true])
            ->assertExitCode(0);

        Storage::disk('s3')->assertMissing('about/hero.jpg');
    }

    public function test_migrate_empty_disk_succeeds()
    {
        Storage::fake('public');
        Storage::fake('s3');

        $this->artisan('media:migrate-to-r2')
            ->expectsOutput('No files found on local public disk.')
            ->assertExitCode(0);
    }

    public function test_verify_option_inspects_database_media()
    {
        Storage::fake('public');
        Storage::fake('s3');

        Project::create([
            'title' => 'Sample Project',
            'slug' => 'sample-project',
            'category' => 'Residential',
            'hero_image' => 'projects/hero/verified.jpg',
            'gallery_images' => ['projects/gallery/gal1.jpg'],
        ]);

        SiteSetting::create([
            'key' => 'about_hero_image',
            'value' => 'about/hero_monument.jpg',
        ]);

        // Put the files in public and migrate
        Storage::disk('public')->put('projects/hero/verified.jpg', 'hero');
        Storage::disk('public')->put('projects/gallery/gal1.jpg', 'gallery');
        Storage::disk('public')->put('about/hero_monument.jpg', 'about');

        $this->artisan('media:migrate-to-r2', ['--verify' => true])
            ->assertExitCode(0);

        Storage::disk('s3')->assertExists('projects/hero/verified.jpg');
        Storage::disk('s3')->assertExists('projects/gallery/gal1.jpg');
        Storage::disk('s3')->assertExists('about/hero_monument.jpg');
    }
}
