<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedStory extends Model
{
    protected $fillable = [
        'title',
        'category',
        'image',
        'url',
        'sort_order',
    ];
}
