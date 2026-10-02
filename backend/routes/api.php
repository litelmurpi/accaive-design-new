<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Support\ApiHelper;

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

// Health & Diagnostic Ping
Route::get('/ping', function () {
    return response()->json([
        'status' => 'pong',
        'app_url' => config('app.url'),
        'cache_driver' => config('cache.default'),
        'timestamp' => now()->toIso8601String(),
    ]);
});

// Cache TTL in seconds (5 minutes)
$ttl = 300;

// PROJECTS
Route::get('/projects', function (Request $request) use ($ttl) {
    $isFeatured = $request->boolean('featured');
    $cacheKey = 'projects_list_' . ($isFeatured ? 'featured' : 'all');
    
    $projects = ApiHelper::cacheRemember($cacheKey, $ttl, function () use ($isFeatured) {
        $query = Project::select('id', 'title', 'slug', 'category', 'location', 'status', 'description', 'client', 'year', 'hero_image', 'size', 'span', 'is_featured', 'sort_order');
        if ($isFeatured) {
            $query->where('is_featured', true);
        }
        return $query->orderBy('sort_order')->get()->map(function ($p) {
            if ($p->hero_image) $p->hero_image = ApiHelper::resolveMediaUrl($p->hero_image);
            return $p;
        });
    });
    return ApiHelper::cachedResponse($projects);
});

Route::get('/projects/{slug}', function ($slug) use ($ttl) {
    $cacheKey = 'project_detail_' . $slug;
    
    $project = ApiHelper::cacheRemember($cacheKey, $ttl, function () use ($slug) {
        $p = Project::where('slug', $slug)->firstOrFail();
        
        // Handle gallery images: can be array (from casts) or JSON string
        $gallery = is_array($p->gallery_images)
            ? $p->gallery_images
            : (json_decode($p->gallery_images, true) ?? []);

        $p->gallery_images = array_values(array_filter(array_map(function ($img) {
            return ApiHelper::resolveMediaUrl($img);
        }, $gallery)));

        // Handle team in charge: ensure clean array
        if (is_string($p->team_in_charge)) {
            $p->team_in_charge = json_decode($p->team_in_charge, true)
                ?? array_values(array_filter(array_map('trim', explode(',', $p->team_in_charge))));
        }

        if ($p->hero_image) $p->hero_image = ApiHelper::resolveMediaUrl($p->hero_image);
        return $p;
    });
    return ApiHelper::cachedResponse($project);
});

// SERVICES
Route::get('/services', function () use ($ttl) {
    $services = ApiHelper::cacheRemember('services_list', $ttl, function () {
        return Service::orderBy('sort_order')->get()->map(function ($service) {
            if ($service->image) $service->image = ApiHelper::resolveMediaUrl($service->image);
            return $service;
        });
    });
    return ApiHelper::cachedResponse($services);
});

// TEAM
Route::get('/team', function () use ($ttl) {
    $team = ApiHelper::cacheRemember('team_list', $ttl, function () {
        return TeamMember::orderBy('sort_order')->get()->map(function ($member) {
            if ($member->photo) $member->photo = ApiHelper::resolveMediaUrl($member->photo);
            return $member;
        });
    });
    return ApiHelper::cachedResponse($team);
});

// EXHIBITIONS
Route::get('/exhibitions', function () use ($ttl) {
    $exhibitions = ApiHelper::cacheRemember('exhibitions_list', $ttl, function () {
        return Exhibition::orderBy('sort_order')->get()->map(function ($item) {
            if ($item->image) $item->image = ApiHelper::resolveMediaUrl($item->image);
            return $item;
        });
    });
    return ApiHelper::cachedResponse($exhibitions);
});

// PRESS ARTICLES
Route::get('/press', function () use ($ttl) {
    $press = ApiHelper::cacheRemember('press_list', $ttl, function () {
        return PressArticle::orderBy('published_at', 'desc')->get();
    });
    return ApiHelper::cachedResponse($press);
});

// CAREERS (Job Openings)
Route::get('/careers', function () use ($ttl) {
    $careers = ApiHelper::cacheRemember('careers_list', $ttl, function () {
        return JobOpening::where('is_active', true)->get();
    });
    return ApiHelper::cachedResponse($careers);
});

// PROGRAMS
Route::get('/programs', function () use ($ttl) {
    $programs = ApiHelper::cacheRemember('programs_list', $ttl, function () {
        return Program::orderBy('sort_order')->get()->map(function ($prog) {
            $prog->features = json_decode($prog->features);
            if ($prog->image) $prog->image = ApiHelper::resolveMediaUrl($prog->image);
            return $prog;
        });
    });
    return ApiHelper::cachedResponse($programs);
});

// FEATURED STORIES
Route::get('/featured-stories', function () use ($ttl) {
    $stories = ApiHelper::cacheRemember('featured_stories_list', $ttl, function () {
        return FeaturedStory::orderBy('sort_order')->get()->map(function ($story) {
            if ($story->image) $story->image = ApiHelper::resolveMediaUrl($story->image);
            return $story;
        });
    });
    return ApiHelper::cachedResponse($stories);
});

// SETTINGS
Route::get('/settings', function () use ($ttl) {
    $settings = ApiHelper::cacheRemember('site_settings', $ttl, function () {
        $all = SiteSetting::all()->pluck('value', 'key')->toArray();
        $cleaned = [];
        foreach ($all as $key => $val) {
            if ($val === 'null' || $val === 'undefined' || $val === 'NULL' || $val === '') {
                $cleaned[$key] = null;
            } else {
                $cleaned[$key] = $val;
            }
        }
        $mediaKeys = ['about_hero_image', 'about_hub1_image', 'about_hub2_image'];
        foreach ($mediaKeys as $mk) {
            if (!empty($cleaned[$mk])) {
                $cleaned[$mk] = ApiHelper::resolveMediaUrl($cleaned[$mk]);
            }
        }
        return $cleaned;
    });
    return ApiHelper::cachedResponse($settings);
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
