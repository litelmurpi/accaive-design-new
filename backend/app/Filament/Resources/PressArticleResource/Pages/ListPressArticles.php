<?php

namespace App\Filament\Resources\PressArticleResource\Pages;

use App\Filament\Resources\PressArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPressArticles extends ListRecords
{
    protected static string $resource = PressArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
