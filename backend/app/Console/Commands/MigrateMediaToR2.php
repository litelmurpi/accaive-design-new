<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateMediaToR2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:migrate-to-r2
                            {--dry-run : Preview files without uploading}
                            {--force : Overwrite files that already exist on R2}
                            {--verify : Verify DB media paths exist on R2 after migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate media files from local public disk to Cloudflare R2 (S3)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $source = Storage::disk('public');
        $dest = Storage::disk('s3');
        $isDryRun = (bool) $this->option('dry-run');
        $force = (bool) $this->option('force');

        $files = array_values(array_filter($source->allFiles(), function ($path) {
            return !str_starts_with(basename($path), '.');
        }));
        $total = count($files);

        if ($total === 0) {
            $this->info('No files found on local public disk.');
            if ($this->option('verify')) {
                $this->verifyDatabaseMedia($dest);
            }
            return self::SUCCESS;
        }

        $this->info(($isDryRun ? '[DRY RUN] ' : '') . "Found {$total} file(s) on local public disk.");
        $bar = $this->output->createProgressBar($total);

        $copied = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($files as $path) {
            $bar->advance();

            $existsOnDest = false;
            if (!$force) {
                try {
                    $existsOnDest = $dest->exists($path);
                } catch (\Throwable $e) {
                    if (!$isDryRun) {
                        $failed++;
                        $this->newLine();
                        $this->error("Cannot connect to destination disk for {$path}: " . $e->getMessage());
                        break;
                    }
                }
            }

            if ($existsOnDest) {
                $skipped++;
                continue;
            }

            if ($isDryRun) {
                $copied++;
                continue;
            }

            try {
                $stream = $source->readStream($path);
                if ($stream === false) {
                    throw new \RuntimeException("Unable to open read stream for: {$path}");
                }

                $dest->writeStream($path, $stream, ['visibility' => 'public']);

                if (is_resource($stream)) {
                    fclose($stream);
                }
                $copied++;
            } catch (\Throwable $e) {
                $failed++;
                $this->newLine();
                $this->error("Failed to copy {$path}: " . $e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine(2);

        $this->table(
            ['Metric', 'Count'],
            [
                ['Total files scanned', $total],
                [$isDryRun ? 'Would copy' : 'Copied to R2', $copied],
                ['Skipped (already exists)', $skipped],
                ['Failed', $failed],
            ]
        );

        if ($this->option('verify')) {
            $this->verifyDatabaseMedia($dest);
        }

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }

    /**
     * Verify database media fields against destination disk.
     */
    protected function verifyDatabaseMedia($dest): void
    {
        $this->info('Verifying database media paths on R2...');
        $missing = [];

        // Check single-path media fields
        $modelsToCheck = [
            [\App\Models\Project::class, 'hero_image'],
            [\App\Models\TeamMember::class, 'photo'],
            [\App\Models\Service::class, 'image'],
            [\App\Models\Program::class, 'image'],
            [\App\Models\Exhibition::class, 'image'],
            [\App\Models\FeaturedStory::class, 'image'],
        ];

        foreach ($modelsToCheck as [$modelClass, $column]) {
            if (!class_exists($modelClass)) {
                continue;
            }

            try {
                $records = $modelClass::whereNotNull($column)->where($column, '!=', '')->get();
                foreach ($records as $record) {
                    $path = $record->{$column};
                    if ($path && !str_starts_with($path, 'http://') && !str_starts_with($path, 'https://')) {
                        if (!$dest->exists($path)) {
                            $missing[] = "{$modelClass}#{$record->id} ({$column}) -> {$path}";
                        }
                    }
                }
            } catch (\Throwable $e) {
                $this->warn("Could not query {$modelClass}: " . $e->getMessage());
            }
        }

        // Check gallery_images on Project
        try {
            $projects = \App\Models\Project::whereNotNull('gallery_images')->get();
            foreach ($projects as $project) {
                $gallery = is_array($project->gallery_images)
                    ? $project->gallery_images
                    : (json_decode($project->gallery_images, true) ?? []);

                foreach ($gallery as $img) {
                    if ($img && !str_starts_with($img, 'http://') && !str_starts_with($img, 'https://')) {
                        if (!$dest->exists($img)) {
                            $missing[] = "Project#{$project->id} (gallery) -> {$img}";
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            $this->warn("Could not verify project gallery: " . $e->getMessage());
        }

        // Check SiteSettings media keys
        try {
            $mediaKeys = ['about_hero_image', 'about_hub1_image', 'about_hub2_image'];
            foreach ($mediaKeys as $key) {
                $setting = \App\Models\SiteSetting::where('key', $key)->first();
                if ($setting && $setting->value) {
                    $val = $setting->value;
                    if (!str_starts_with($val, 'http://') && !str_starts_with($val, 'https://')) {
                        if (!$dest->exists($val)) {
                            $missing[] = "SiteSetting:{$key} -> {$val}";
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            $this->warn("Could not verify site settings: " . $e->getMessage());
        }

        if (empty($missing)) {
            $this->info('All database media paths verified successfully on R2.');
        } else {
            $this->warn('Missing files on R2:');
            foreach ($missing as $m) {
                $this->line("  - {$m}");
            }
        }
    }
}
