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
    return response()->json(['data' => $query->orderBy('sort_order')->get()]);
});

Route::get('/projects/{slug}', function ($slug) {
    $project = Project::where('slug', $slug)->firstOrFail();
    $project->gallery_images = json_decode($project->gallery_images); // parse JSON
    return response()->json(['data' => $project]);
});

// SERVICES
Route::get('/services', function () {
    return response()->json(['data' => Service::orderBy('sort_order')->get()]);
});

// TEAM
Route::get('/team', function () {
    return response()->json(['data' => TeamMember::orderBy('sort_order')->get()]);
});

// EXHIBITIONS
Route::get('/exhibitions', function () {
    return response()->json(['data' => Exhibition::orderBy('sort_order')->get()]);
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
        return $prog;
    });
    return response()->json(['data' => $programs]);
});

// FEATURED STORIES
Route::get('/featured-stories', function () {
    return response()->json(['data' => FeaturedStory::orderBy('sort_order')->get()]);
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
