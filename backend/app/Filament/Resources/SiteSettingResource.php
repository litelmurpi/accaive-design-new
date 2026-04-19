<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Pengaturan Website';
    protected static ?string $modelLabel = 'Pengaturan';
    protected static ?string $pluralModelLabel = 'Pengaturan Website';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Pengaturan')
                    ->description('Konfigurasi umum website. Ubah nilai sesuai kebutuhan.')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('Nama Pengaturan')
                            ->required()
                            ->disabled()
                            ->helperText('ID unik pengaturan ini (tidak bisa diubah).'),
                        Forms\Components\TextInput::make('value')
                            ->label('Nilai / Isi')
                            ->required()
                            ->helperText('Ubah nilai ini untuk memperbarui pengaturan di website.'),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Pengaturan')
                    ->searchable()
                    ->fontFamily('mono')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('value')
                    ->label('Nilai')
                    ->searchable()
                    ->wrap(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ubah'),
            ])
            ->emptyStateHeading('Belum ada pengaturan')
            ->emptyStateDescription('Pengaturan website akan muncul di sini.')
            ->emptyStateIcon('heroicon-o-cog-6-tooth');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
