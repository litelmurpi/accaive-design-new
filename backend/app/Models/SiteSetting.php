<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $guarded = [];

    protected static function booted(): void
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('site_settings');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('site_settings');
        });
    }
}
