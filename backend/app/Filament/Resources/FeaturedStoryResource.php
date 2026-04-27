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
    protected static ?string $navigationLabel = 'Cerita Unggulan';
    protected static ?string $modelLabel = 'Cerita Unggulan';
    protected static ?string $pluralModelLabel = 'Cerita Unggulan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Sorotan Cerita')
                    ->compact()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Cerita')
                            ->required()
                            ->placeholder('contoh: Designing the Future of Work'),
                        Forms\Components\TextInput::make('category')
                            ->label('Kategori Konten')
                            ->placeholder('contoh: Artikel, Berita'),
                        Forms\Components\TextInput::make('url')
                            ->label('Tautan Tujuan')
                            ->placeholder('contoh: /case-studies'),
                        Forms\Components\FileUpload::make('image')
                            ->label('Thumbnail Cerita')
                            ->image()
                            ->directory('stories')
                            ->helperText('Petunjuk visual untuk menu navigasi.')
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
            ->striped()
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit')
                    ->slideOver(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Hapus'),
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
        ];
    }
}
