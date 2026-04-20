<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'Company';
    protected static ?string $navigationLabel = 'Expertise';
    protected static ?string $modelLabel = 'Service';
    protected static ?string $pluralModelLabel = 'Services';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Service Offering')
                    ->description('Define the studio services shown on the landing page.')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Service Code')
                            ->placeholder('e.g. 01')
                            ->helperText('Index number shown before the title.'),
                        Forms\Components\TextInput::make('title')
                            ->label('Service Title')
                            ->required()
                            ->placeholder('e.g. Spatial Strategy'),
                        Forms\Components\Textarea::make('description')
                            ->label('Brief Description')
                            ->placeholder('Describe this expertise in 1-2 sentences...')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->fontFamily('mono')
                    ->size('lg'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Layanan')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada layanan')
            ->emptyStateDescription('Klik tombol "Buat Layanan" untuk menambah layanan baru.')
            ->emptyStateIcon('heroicon-o-wrench-screwdriver');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
