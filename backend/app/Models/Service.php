<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('services_list');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('services_list');
        });
    }
}
