<?php

namespace App\Filament\Resources\FeaturedStoryResource\Pages;

use App\Filament\Resources\FeaturedStoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeaturedStory extends EditRecord
{
    protected static string $resource = FeaturedStoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
