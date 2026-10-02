<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class ApiHelper
{
    /**
     * Safely resolve media URL for local storage or cloud disk (S3 / R2)
     */
    public static function resolveMediaUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $disk = config('filesystems.default', 'public');
        if ($disk === 's3') {
            return Storage::disk('s3')->url($path);
        }

        return url('storage/' . ltrim($path, '/'));
    }

    /**
     * Safely remember data in cache with automatic fallback to direct query if cache fails
     */
    public static function cacheRemember(string $key, int $ttl, \Closure $callback)
    {
        try {
            return Cache::remember($key, $ttl, $callback);
        } catch (\Throwable $e) {
            \Log::warning("Cache failed for key {$key}: " . $e->getMessage());
            return $callback();
        }
    }

    /**
     * Return standard JSON response with Cache-Control header
     */
    public static function cachedResponse($data, int $maxAge = 300): JsonResponse
    {
        return response()->json(['data' => $data])
            ->header('Cache-Control', "public, max-age={$maxAge}");
    }
}
