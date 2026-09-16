<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

// Import all models
use App\Models\Project;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Exhibition;
use App\Models\PressArticle;
use App\Models\JobOpening;
use App\Models\Program;
use App\Models\FeaturedStory;
use App\Models\ContactSubmission;
use App\Models\SiteSetting;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Cache TTL in seconds (5 minutes)
$ttl = 300;

// Helper to return cached response with headers
if (!function_exists('cachedResponse')) {
    function cachedResponse($data) {
        return response()->json(['data' => $data])
            ->header('Cache-Control', 'public, max-age=300');
    }
}

// Universal media URL resolver (supports local storage, public disk, and S3 / Cloudflare R2)
if (!function_exists('resolveMediaUrl')) {
    function resolveMediaUrl($path) {
        if (!$path) return null;
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        $disk = config('filesystems.default', 'public');
        if ($disk === 's3') {
            return Storage::disk('s3')->url($path);
        }
        return url('storage/' . ltrim($path, '/'));
    }
}

// PROJECTS
Route::get('/projects', function (Request $request) use ($ttl) {
    $isFeatured = $request->boolean('featured');
    $cacheKey = 'projects_list_' . ($isFeatured ? 'featured' : 'all');
    
    $projects = Cache::remember($cacheKey, $ttl, function () use ($isFeatured) {
        $query = Project::select('id', 'title', 'slug', 'category', 'location', 'status', 'description', 'client', 'year', 'hero_image', 'size', 'span', 'is_featured', 'sort_order');
        if ($isFeatured) {
            $query->where('is_featured', true);
        }
        return $query->orderBy('sort_order')->get()->map(function ($p) {
            if ($p->hero_image) $p->hero_image = resolveMediaUrl($p->hero_image);
            return $p;
        });
    });
    return cachedResponse($projects);
});

Route::get('/projects/{slug}', function ($slug) use ($ttl) {
    $cacheKey = 'project_detail_' . $slug;
    
    $project = Cache::remember($cacheKey, $ttl, function () use ($slug) {
        $p = Project::where('slug', $slug)->firstOrFail();
        
        // Handle gallery images: can be array (from casts) or JSON string
        $gallery = is_array($p->gallery_images)
            ? $p->gallery_images
            : (json_decode($p->gallery_images, true) ?? []);

        $p->gallery_images = array_values(array_filter(array_map(function ($img) {
            return resolveMediaUrl($img);
        }, $gallery)));

        // Handle team in charge: ensure clean array
        if (is_string($p->team_in_charge)) {
            $p->team_in_charge = json_decode($p->team_in_charge, true)
                ?? array_values(array_filter(array_map('trim', explode(',', $p->team_in_charge))));
        }

        if ($p->hero_image) $p->hero_image = resolveMediaUrl($p->hero_image);
        return $p;
    });
    return cachedResponse($project);
});

// SERVICES
Route::get('/services', function () use ($ttl) {
    $services = Cache::remember('services_list', $ttl, function () {
        return Service::orderBy('sort_order')->get();
    });
    return cachedResponse($services);
});

// TEAM
Route::get('/team', function () use ($ttl) {
    $team = Cache::remember('team_list', $ttl, function () {
        return TeamMember::orderBy('sort_order')->get()->map(function ($member) {
            if ($member->photo) $member->photo = resolveMediaUrl($member->photo);
            return $member;
        });
    });
    return cachedResponse($team);
});

// EXHIBITIONS
Route::get('/exhibitions', function () use ($ttl) {
    $exhibitions = Cache::remember('exhibitions_list', $ttl, function () {
        return Exhibition::orderBy('sort_order')->get()->map(function ($item) {
            if ($item->image) $item->image = resolveMediaUrl($item->image);
            return $item;
        });
    });
    return cachedResponse($exhibitions);
});

// PRESS ARTICLES
Route::get('/press', function () use ($ttl) {
    $press = Cache::remember('press_list', $ttl, function () {
        return PressArticle::orderBy('published_at', 'desc')->get();
    });
    return cachedResponse($press);
});

// CAREERS (Job Openings)
Route::get('/careers', function () use ($ttl) {
    $careers = Cache::remember('careers_list', $ttl, function () {
        return JobOpening::where('is_active', true)->get();
    });
    return cachedResponse($careers);
});

// PROGRAMS
Route::get('/programs', function () use ($ttl) {
    $programs = Cache::remember('programs_list', $ttl, function () {
        return Program::orderBy('sort_order')->get()->map(function ($prog) {
            $prog->features = json_decode($prog->features);
            if ($prog->image) $prog->image = resolveMediaUrl($prog->image);
            return $prog;
        });
    });
    return cachedResponse($programs);
});

// FEATURED STORIES
Route::get('/featured-stories', function () use ($ttl) {
    $stories = Cache::remember('featured_stories_list', $ttl, function () {
        return FeaturedStory::orderBy('sort_order')->get()->map(function ($story) {
            if ($story->image) $story->image = resolveMediaUrl($story->image);
            return $story;
        });
    });
    return cachedResponse($stories);
});

// SETTINGS
Route::get('/settings', function () use ($ttl) {
    $settings = Cache::remember('site_settings', $ttl, function () {
        return SiteSetting::all()->pluck('value', 'key');
    });
    return cachedResponse($settings);
});

// CONTACT (Phase 3) - No cache for POST
Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'company' => 'nullable|string|max:255',
        'budget' => 'nullable|string|max:255',
        'message' => 'required|string',
    ]);

    $submission = ContactSubmission::create($validated);

    return response()->json([
        'message' => 'Contact submission successful',
        'data' => $submission
    ], 201);
});
