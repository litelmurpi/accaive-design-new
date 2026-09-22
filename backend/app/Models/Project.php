<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    protected $casts = [
        'gallery_images' => 'array',
        'team_in_charge' => 'array',
        'is_featured' => 'boolean',
    ];

    protected static function booted()
    {
        static::saved(function ($project) {
            \Illuminate\Support\Facades\Cache::forget('projects_list_featured');
            \Illuminate\Support\Facades\Cache::forget('projects_list_all');
            if (!empty($project->slug)) {
                \Illuminate\Support\Facades\Cache::forget('project_detail_' . $project->slug);
            }
        });

        static::deleted(function ($project) {
            \Illuminate\Support\Facades\Cache::forget('projects_list_featured');
            \Illuminate\Support\Facades\Cache::forget('projects_list_all');
            if (!empty($project->slug)) {
                \Illuminate\Support\Facades\Cache::forget('project_detail_' . $project->slug);
            }
        });
    }
}
