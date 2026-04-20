<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeaturedStoryResource\Pages;
use App\Models\FeaturedStory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FeaturedStoryResource extends Resource
{
    protected static ?string $model = FeaturedStory::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Featured Stories';
    protected static ?string $modelLabel = 'Featured Story';
    protected static ?string $pluralModelLabel = 'Featured Stories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Story Highlight')
                    ->description('Curated content for the main navigation highlight.')
                    ->icon('heroicon-o-star')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Story Title')
                            ->required()
                            ->placeholder('e.g. Designing the Future of Work'),
                        Forms\Components\TextInput::make('category')
                            ->label('Content Category')
                            ->placeholder('e.g. Article, News'),
                        Forms\Components\TextInput::make('url')
                            ->label('Destination Link')
                            ->placeholder('e.g. /case-studies'),
                        Forms\Components\FileUpload::make('image')
                            ->label('Story Thumbnail')
                            ->image()
                            ->directory('stories')
                            ->helperText('Visual cue for the navigation menu.')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->square(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge(),
                Tables\Columns\TextColumn::make('url')
                    ->label('Link')
                    ->icon('heroicon-o-link')
                    ->color('info'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada sorotan')
            ->emptyStateDescription('Tambahkan item sorotan untuk menu navigasi.')
            ->emptyStateIcon('heroicon-o-star');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeaturedStories::route('/'),
            'create' => Pages\CreateFeaturedStory::route('/create'),
            'edit' => Pages\EditFeaturedStory::route('/{record}/edit'),
        ];
    }
}
