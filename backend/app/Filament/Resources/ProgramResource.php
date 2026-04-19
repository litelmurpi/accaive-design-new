<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Models\Program;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Program';
    protected static ?string $modelLabel = 'Program';
    protected static ?string $pluralModelLabel = 'Daftar Program';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Program')
                    ->description('Program edukasi atau inisiatif khusus yang ditampilkan di halaman "Programs".')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Nama Program')
                            ->required()
                            ->placeholder('contoh: Design Incubator'),
                        Forms\Components\TextInput::make('subtitle')
                            ->label('Subtitle / Tagline')
                            ->placeholder('contoh: For Emerging Talent'),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Program')
                            ->placeholder('Jelaskan program ini secara detail...')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Visual & Fitur')
                    ->description('Tambahkan gambar dan daftar keunggulan program.')
                    ->icon('heroicon-o-photo')
                    ->collapsible()
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Gambar Program')
                            ->image()
                            ->imageEditor()
                            ->directory('programs')
                            ->helperText('Gambar yang merepresentasikan program ini.')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('features')
                            ->label('Fitur / Keunggulan (JSON)')
                            ->helperText('Daftar fitur dalam format JSON. Contoh: ["Mentorship","Weekly critiques"]')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
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
                    ->label('Nama Program')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Tagline')
                    ->color('gray'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->emptyStateHeading('Belum ada program')
            ->emptyStateDescription('Klik tombol "Buat Program" untuk menambah program baru.')
            ->emptyStateIcon('heroicon-o-academic-cap');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
