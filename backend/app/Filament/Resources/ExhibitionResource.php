<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExhibitionResource\Pages;
use App\Models\Exhibition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExhibitionResource extends Resource
{
    protected static ?string $model = Exhibition::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?string $navigationLabel = 'Pameran';
    protected static ?string $modelLabel = 'Pameran';
    protected static ?string $pluralModelLabel = 'Daftar Pameran';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Pameran')
                    ->description('Informasi pameran yang tampil di halaman "Arts & Culture".')
                    ->icon('heroicon-o-sparkles')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Pameran')
                            ->required()
                            ->placeholder('contoh: Modern Heritage'),
                        Forms\Components\TextInput::make('location')
                            ->label('Lokasi')
                            ->required()
                            ->placeholder('contoh: London, UK'),
                        Forms\Components\TextInput::make('year')
                            ->label('Tahun')
                            ->placeholder('contoh: 2024'),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->placeholder('Ceritakan tentang pameran ini...')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('image')
                            ->label('Foto Pameran')
                            ->image()
                            ->imageEditor()
                            ->directory('exhibitions')
                            ->helperText('Foto landscape berkualitas tinggi. Ukuran ideal: 1600x900px.')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto')
                    ->square(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->icon('heroicon-o-map-pin'),
                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),
            ])
            ->defaultSort('year', 'desc')
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada pameran')
            ->emptyStateDescription('Klik tombol "Buat Pameran" untuk menambah pameran baru.')
            ->emptyStateIcon('heroicon-o-sparkles');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExhibitions::route('/'),
            'create' => Pages\CreateExhibition::route('/create'),
            'edit' => Pages\EditExhibition::route('/{record}/edit'),
        ];
    }
}
