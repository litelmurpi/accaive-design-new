<?php

namespace App\Filament\Resources\FeaturedStoryResource\Pages;

use App\Filament\Resources\FeaturedStoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFeaturedStory extends CreateRecord
{
    protected static string $resource = FeaturedStoryResource::class;
}
