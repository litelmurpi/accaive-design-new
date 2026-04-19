<?php

namespace App\Filament\Resources\FeaturedStoryResource\Pages;

use App\Filament\Resources\FeaturedStoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeaturedStories extends ListRecords
{
    protected static string $resource = FeaturedStoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
