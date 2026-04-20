<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?string $navigationLabel = 'Proyek';
    protected static ?string $modelLabel = 'Proyek';
    protected static ?string $pluralModelLabel = 'Semua Proyek';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Section::make('Core Information')
                            ->description('Essential details about the project identity.')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Project Title')
                                    ->required()
                                    ->placeholder('e.g. The Void House')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                                Forms\Components\TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('the-void-house'),
                                Forms\Components\TextInput::make('category')
                                    ->label('Category')
                                    ->required()
                                    ->placeholder('e.g. Residential'),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('client')
                                            ->label('Client Name')
                                            ->placeholder('Private Client'),
                                        Forms\Components\TextInput::make('year')
                                            ->label('Completion Year')
                                            ->placeholder('2025'),
                                    ]),
                                Forms\Components\Textarea::make('description')
                                    ->label('Project Narrative')
                                    ->placeholder('Tell the story behind this architecture...')
                                    ->rows(6),
                            ])->columnSpan(2),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Visual Narrative')
                                    ->description('Main imagery for the project.')
                                    ->icon('heroicon-o-photo')
                                    ->schema([
                                        Forms\Components\FileUpload::make('hero_image')
                                            ->label('Hero Image')
                                            ->image()
                                            ->directory('projects/hero')
                                            ->required()
                                            ->helperText('High-resolution landscape (16:9 recommended).'),
                                    ]),

                                Forms\Components\Section::make('Grid & Curation')
                                    ->description('How this project appears in the work grid.')
                                    ->icon('heroicon-o-squares-2x2')
                                    ->schema([
                                        Forms\Components\Select::make('size')
                                            ->label('Card Proportion')
                                            ->options([
                                                'large' => 'Large (Full Width)',
                                                'small' => 'Small (Standard)',
                                                'tall' => 'Tall (Portrait)',
                                                'wide' => 'Wide (Horizontal)',
                                            ])
                                            ->default('small'),
                                        Forms\Components\TextInput::make('span')
                                            ->label('Grid Span (Tailwind)')
                                            ->placeholder('md:col-span-6'),
                                        Forms\Components\TextInput::make('sort_order')
                                            ->label('Sequence Position')
                                            ->numeric()
                                            ->default(0),
                                        Forms\Components\Toggle::make('is_featured')
                                            ->label('Feature on Homepage')
                                            ->inline(false)
                                            ->default(true),
                                    ]),
                            ])->columnSpan(1),
                    ]),

                Forms\Components\Section::make('Gallery Collection')
                    ->description('Additional visuals for the detailed case study.')
                    ->icon('heroicon-o-rectangle-stack')
                    ->collapsed()
                    ->schema([
                        Forms\Components\Textarea::make('gallery_images')
                            ->label('Gallery Data (JSON)')
                            ->placeholder('["url1", "url2"]')
                            ->helperText('Enter an array of image URLs or IDs.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('hero_image')
                    ->label('Foto')
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Proyek')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Status Featured'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Hapus yang dipilih'),
                ]),
            ])
            ->emptyStateHeading('Belum ada proyek')
            ->emptyStateDescription('Klik tombol "Buat Proyek" untuk menambahkan proyek pertama.')
            ->emptyStateIcon('heroicon-o-building-office-2');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
