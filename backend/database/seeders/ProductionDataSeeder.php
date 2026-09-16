<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductionDataSeeder extends Seeder
{
    /**
     * Run the database seeds from captured Railway production data.
     */
    public function run(): void
    {
        $dataPath = database_path('data');

        // 1. SERVICES
        if (file_exists("$dataPath/services.json")) {
            $services = json_decode(file_get_contents("$dataPath/services.json"), true);
            $data = $services['data'] ?? [];
            if (!empty($data)) {
                DB::table('services')->truncate();
                foreach ($data as $item) {
                    DB::table('services')->insert([
                        'id' => $item['id'],
                        'code' => $item['code'] ?? null,
                        'title' => $item['title'] ?? '',
                        'description' => $item['description'] ?? '',
                        'sort_order' => $item['sort_order'] ?? 0,
                        'created_at' => $item['created_at'] ?? now(),
                        'updated_at' => $item['updated_at'] ?? now(),
                    ]);
                }
                $this->command?->info('✓ Seeded ' . count($data) . ' services from Railway production.');
            }
        }

        // 2. TEAM MEMBERS
        if (file_exists("$dataPath/team.json")) {
            $team = json_decode(file_get_contents("$dataPath/team.json"), true);
            $data = $team['data'] ?? [];
            if (!empty($data)) {
                DB::table('team_members')->truncate();
                foreach ($data as $item) {
                    DB::table('team_members')->insert([
                        'id' => $item['id'],
                        'name' => $item['name'] ?? '',
                        'role' => $item['role'] ?? '',
                        'photo' => $item['photo'] ?? null,
                        'bio' => $item['bio'] ?? null,
                        'sort_order' => $item['sort_order'] ?? 0,
                        'created_at' => $item['created_at'] ?? now(),
                        'updated_at' => $item['updated_at'] ?? now(),
                    ]);
                }
                $this->command?->info('✓ Seeded ' . count($data) . ' team members from Railway production.');
            }
        }

        // 3. PROJECTS
        if (file_exists("$dataPath/projects.json")) {
            $projects = json_decode(file_get_contents("$dataPath/projects.json"), true);
            $data = $projects['data'] ?? [];
            if (!empty($data)) {
                DB::table('projects')->truncate();
                foreach ($data as $item) {
                    // Extract relative path from hero_image if it points to railway storage
                    $heroImage = $item['hero_image'] ?? null;
                    if ($heroImage && str_contains($heroImage, '/storage/')) {
                        $parts = explode('/storage/', $heroImage);
                        $heroImage = $parts[1] ?? $heroImage;
                    }

                    $team = $item['team_in_charge'] ?? null;
                    if (is_array($team)) {
                        $team = json_encode($team);
                    }

                    DB::table('projects')->insert([
                        'id' => $item['id'],
                        'title' => $item['title'] ?? '',
                        'slug' => $item['slug'] ?? '',
                        'category' => $item['category'] ?? '',
                        'location' => $item['location'] ?? null,
                        'status' => $item['status'] ?? 'Completed',
                        'client' => $item['client'] ?? null,
                        'year' => $item['year'] ?? null,
                        'description' => $item['description'] ?? '',
                        'team_in_charge' => $team,
                        'hero_image' => $heroImage,
                        'size' => $item['size'] ?? 'small',
                        'span' => $item['span'] ?? null,
                        'gallery_images' => json_encode($item['gallery_images'] ?? []),
                        'is_featured' => (bool) ($item['is_featured'] ?? false),
                        'sort_order' => $item['sort_order'] ?? 0,
                        'created_at' => $item['created_at'] ?? now(),
                        'updated_at' => $item['updated_at'] ?? now(),
                    ]);
                }
                $this->command?->info('✓ Seeded ' . count($data) . ' projects from Railway production.');
            }
        }

        // 4. EXHIBITIONS
        if (file_exists("$dataPath/exhibitions.json")) {
            $exhibitions = json_decode(file_get_contents("$dataPath/exhibitions.json"), true);
            $data = $exhibitions['data'] ?? [];
            if (!empty($data)) {
                DB::table('exhibitions')->truncate();
                foreach ($data as $item) {
                    $img = $item['image'] ?? null;
                    if ($img && str_contains($img, '/storage/')) {
                        $parts = explode('/storage/', $img);
                        $img = $parts[1] ?? $img;
                    }
                    DB::table('exhibitions')->insert([
                        'id' => $item['id'],
                        'title' => $item['title'] ?? '',
                        'location' => $item['location'] ?? '',
                        'year' => $item['year'] ?? '',
                        'image' => $img,
                        'sort_order' => $item['sort_order'] ?? 0,
                        'created_at' => $item['created_at'] ?? now(),
                        'updated_at' => $item['updated_at'] ?? now(),
                    ]);
                }
                $this->command?->info('✓ Seeded ' . count($data) . ' exhibitions from Railway production.');
            }
        }

        // 5. PROGRAMS
        if (file_exists("$dataPath/programs.json")) {
            $programs = json_decode(file_get_contents("$dataPath/programs.json"), true);
            $data = $programs['data'] ?? [];
            if (!empty($data)) {
                DB::table('programs')->truncate();
                foreach ($data as $item) {
                    $img = $item['image'] ?? null;
                    if ($img && str_contains($img, '/storage/')) {
                        $parts = explode('/storage/', $img);
                        $img = $parts[1] ?? $img;
                    }
                    DB::table('programs')->insert([
                        'id' => $item['id'],
                        'title' => $item['title'] ?? '',
                        'description' => $item['description'] ?? '',
                        'image' => $img,
                        'features' => json_encode($item['features'] ?? []),
                        'sort_order' => $item['sort_order'] ?? 0,
                        'created_at' => $item['created_at'] ?? now(),
                        'updated_at' => $item['updated_at'] ?? now(),
                    ]);
                }
                $this->command?->info('✓ Seeded ' . count($data) . ' programs from Railway production.');
            }
        }

        // 6. FEATURED STORIES
        if (file_exists("$dataPath/featured_stories.json")) {
            $stories = json_decode(file_get_contents("$dataPath/featured_stories.json"), true);
            $data = $stories['data'] ?? [];
            if (!empty($data)) {
                DB::table('featured_stories')->truncate();
                foreach ($data as $item) {
                    $img = $item['image'] ?? null;
                    if ($img && str_contains($img, '/storage/')) {
                        $parts = explode('/storage/', $img);
                        $img = $parts[1] ?? $img;
                    }
                    DB::table('featured_stories')->insert([
                        'id' => $item['id'],
                        'title' => $item['title'] ?? '',
                        'category' => $item['category'] ?? '',
                        'author' => $item['author'] ?? '',
                        'image' => $img,
                        'read_time' => $item['read_time'] ?? '',
                        'url' => $item['url'] ?? '',
                        'sort_order' => $item['sort_order'] ?? 0,
                        'created_at' => $item['created_at'] ?? now(),
                        'updated_at' => $item['updated_at'] ?? now(),
                    ]);
                }
                $this->command?->info('✓ Seeded ' . count($data) . ' featured stories from Railway production.');
            }
        }

        // 7. SITE SETTINGS
        if (file_exists("$dataPath/settings.json")) {
            $settings = json_decode(file_get_contents("$dataPath/settings.json"), true);
            $data = $settings['data'] ?? [];
            if (!empty($data)) {
                DB::table('site_settings')->truncate();
                foreach ($data as $key => $value) {
                    DB::table('site_settings')->insert([
                        'key' => $key,
                        'value' => is_string($value) ? $value : json_encode($value),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                $this->command?->info('✓ Seeded ' . count($data) . ' site settings from Railway production.');
            }
        }
    }
}
