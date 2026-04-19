<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobOpeningResource\Pages;
use App\Models\JobOpening;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobOpeningResource extends Resource
{
    protected static ?string $model = JobOpening::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'Company';
    protected static ?string $navigationLabel = 'Lowongan Kerja';
    protected static ?string $modelLabel = 'Lowongan';
    protected static ?string $pluralModelLabel = 'Lowongan Kerja';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Lowongan')
                    ->description('Lowongan kerja yang ditampilkan di halaman "Careers".')
                    ->icon('heroicon-o-briefcase')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Posisi / Jabatan')
                            ->required()
                            ->placeholder('contoh: Senior Architect'),
                        Forms\Components\TextInput::make('department')
                            ->label('Departemen')
                            ->placeholder('contoh: Architecture, Interior Design'),
                        Forms\Components\TextInput::make('location')
                            ->label('Lokasi Kerja')
                            ->placeholder('contoh: New York, Hybrid'),
                        Forms\Components\Select::make('type')
                            ->label('Tipe Pekerjaan')
                            ->options([
                                'Full-time' => '🟢 Full-time',
                                'Part-time' => '🟡 Part-time',
                                'Contract' => '🔵 Kontrak',
                                'Internship' => '🟣 Magang',
                                'Freelance' => '🟠 Freelance',
                            ])
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Posisi')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('department')
                    ->label('Departemen')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->icon('heroicon-o-map-pin'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Full-time' => 'success',
                        'Part-time' => 'warning',
                        'Contract' => 'info',
                        'Internship' => 'danger',
                        default => 'gray',
                    }),
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
            ->emptyStateHeading('Belum ada lowongan kerja')
            ->emptyStateDescription('Klik tombol "Buat Lowongan" untuk membuka posisi baru.')
            ->emptyStateIcon('heroicon-o-briefcase');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobOpenings::route('/'),
            'create' => Pages\CreateJobOpening::route('/create'),
            'edit' => Pages\EditJobOpening::route('/{record}/edit'),
        ];
    }
}
