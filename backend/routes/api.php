<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Middleware for authentication (unused for public reads)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// PROJECTS
Route::get('/projects', function (Request $request) {
    $query = Project::query();
    if ($request->boolean('featured')) {
        $query->where('is_featured', true);
    }
    $projects = $query->orderBy('sort_order')->get()->map(function ($p) {
        if ($p->hero_image && !str_starts_with($p->hero_image, 'http')) $p->hero_image = url('storage/' . $p->hero_image);
        return $p;
    });
    return response()->json(['data' => $projects]);
});

Route::get('/projects/{slug}', function ($slug) {
    $project = Project::where('slug', $slug)->firstOrFail();
    $gallery = json_decode($project->gallery_images) ?? [];
    $project->gallery_images = array_map(function ($img) {
        return str_starts_with($img, 'http') ? $img : url('storage/' . $img);
    }, $gallery);
    if ($project->hero_image && !str_starts_with($project->hero_image, 'http')) $project->hero_image = url('storage/' . $project->hero_image);
    return response()->json(['data' => $project]);
});

// SERVICES
Route::get('/services', function () {
    return response()->json(['data' => Service::orderBy('sort_order')->get()]);
});

// TEAM
Route::get('/team', function () {
    $team = TeamMember::orderBy('sort_order')->get()->map(function ($member) {
        if ($member->photo && !str_starts_with($member->photo, 'http')) $member->photo = url('storage/' . $member->photo);
        return $member;
    });
    return response()->json(['data' => $team]);
});

// EXHIBITIONS
Route::get('/exhibitions', function () {
    $exhibitions = Exhibition::orderBy('sort_order')->get()->map(function ($item) {
        if ($item->image && !str_starts_with($item->image, 'http')) $item->image = url('storage/' . $item->image);
        return $item;
    });
    return response()->json(['data' => $exhibitions]);
});

// PRESS ARTICLES
Route::get('/press', function () {
    return response()->json(['data' => PressArticle::orderBy('published_at', 'desc')->get()]);
});

// CAREERS (Job Openings)
Route::get('/careers', function () {
    return response()->json(['data' => JobOpening::where('is_active', true)->get()]);
});

// PROGRAMS
Route::get('/programs', function () {
    $programs = Program::orderBy('sort_order')->get()->map(function ($prog) {
        $prog->features = json_decode($prog->features);
        if ($prog->image && !str_starts_with($prog->image, 'http')) $prog->image = url('storage/' . $prog->image);
        return $prog;
    });
    return response()->json(['data' => $programs]);
});

// FEATURED STORIES
Route::get('/featured-stories', function () {
    $stories = FeaturedStory::orderBy('sort_order')->get()->map(function ($story) {
        if ($story->image && !str_starts_with($story->image, 'http')) $story->image = url('storage/' . $story->image);
        return $story;
    });
    return response()->json(['data' => $stories]);
});

// SETTINGS
Route::get('/settings', function () {
    $settings = SiteSetting::all()->pluck('value', 'key');
    return response()->json(['data' => $settings]);
});

// CONTACT (Phase 3)
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
