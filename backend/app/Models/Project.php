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
}
