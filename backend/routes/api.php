<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

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

// PROJECTS
Route::get('/projects', function (Request $request) use ($ttl) {
    $isFeatured = $request->boolean('featured');
    $cacheKey = 'projects_list_' . ($isFeatured ? 'featured' : 'all');
    
    $projects = Cache::remember($cacheKey, $ttl, function () use ($isFeatured) {
        $query = Project::select('id', 'title', 'slug', 'category', 'description', 'client', 'hero_image', 'size', 'span', 'is_featured', 'sort_order');
        if ($isFeatured) {
            $query->where('is_featured', true);
        }
        return $query->orderBy('sort_order')->get()->map(function ($p) {
            if ($p->hero_image && !str_starts_with($p->hero_image, 'http')) $p->hero_image = url('storage/' . $p->hero_image);
            return $p;
        });
    });
    return cachedResponse($projects);
});

Route::get('/projects/{slug}', function ($slug) use ($ttl) {
    $cacheKey = 'project_detail_' . $slug;
    
    $project = Cache::remember($cacheKey, $ttl, function () use ($slug) {
        $p = Project::where('slug', $slug)->firstOrFail();
        $gallery = json_decode($p->gallery_images) ?? [];
        $p->gallery_images = array_map(function ($img) {
            return str_starts_with($img, 'http') ? $img : url('storage/' . $img);
        }, $gallery);
        if ($p->hero_image && !str_starts_with($p->hero_image, 'http')) $p->hero_image = url('storage/' . $p->hero_image);
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
            if ($member->photo && !str_starts_with($member->photo, 'http')) $member->photo = url('storage/' . $member->photo);
            return $member;
        });
    });
    return cachedResponse($team);
});

// EXHIBITIONS
Route::get('/exhibitions', function () use ($ttl) {
    $exhibitions = Cache::remember('exhibitions_list', $ttl, function () {
        return Exhibition::orderBy('sort_order')->get()->map(function ($item) {
            if ($item->image && !str_starts_with($item->image, 'http')) $item->image = url('storage/' . $item->image);
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
            if ($prog->image && !str_starts_with($prog->image, 'http')) $prog->image = url('storage/' . $prog->image);
            return $prog;
        });
    });
    return cachedResponse($programs);
});

// FEATURED STORIES
Route::get('/featured-stories', function () use ($ttl) {
    $stories = Cache::remember('featured_stories_list', $ttl, function () {
        return FeaturedStory::orderBy('sort_order')->get()->map(function ($story) {
            if ($story->image && !str_starts_with($story->image, 'http')) $story->image = url('storage/' . $story->image);
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
