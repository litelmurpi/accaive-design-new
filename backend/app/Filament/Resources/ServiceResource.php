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
    protected static ?string $navigationLabel = 'Layanan';
    protected static ?string $modelLabel = 'Layanan';
    protected static ?string $pluralModelLabel = 'Daftar Layanan';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Layanan')
                    ->description('Layanan yang ditampilkan di halaman utama website.')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Kode Layanan')
                            ->placeholder('contoh: 01')
                            ->helperText('Nomor urut yang tampil di depan nama layanan.'),
                        Forms\Components\TextInput::make('title')
                            ->label('Nama Layanan')
                            ->required()
                            ->placeholder('contoh: Spatial Strategy'),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->placeholder('Jelaskan layanan ini dalam 1-2 kalimat...')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0)
                            ->helperText('Angka lebih kecil = tampil lebih dulu.'),
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
