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
                Forms\Components\Section::make('Informasi Proyek')
                    ->description('Isi detail dasar proyek yang akan ditampilkan di website.')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Nama Proyek')
                            ->required()
                            ->placeholder('contoh: The Void House'),
                        Forms\Components\TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->helperText('Otomatis jadi bagian dari link website. Gunakan huruf kecil dan tanda hubung.')
                            ->placeholder('contoh: the-void-house'),
                        Forms\Components\TextInput::make('category')
                            ->label('Kategori')
                            ->required()
                            ->placeholder('contoh: Residential, Commercial, Cultural'),
                        Forms\Components\TextInput::make('client')
                            ->label('Nama Klien')
                            ->placeholder('contoh: Private Client'),
                        Forms\Components\TextInput::make('year')
                            ->label('Tahun')
                            ->placeholder('contoh: 2025'),
                    ])->columns(2),

                Forms\Components\Section::make('Gambar & Visual')
                    ->description('Upload gambar utama proyek. Gunakan gambar berkualitas tinggi untuk tampilan terbaik.')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        Forms\Components\FileUpload::make('hero_image')
                            ->label('Gambar Utama (Hero)')
                            ->image()
                            ->imageEditor()
                            ->directory('projects')
                            ->helperText('Gambar besar yang muncul di bagian atas halaman proyek. Ukuran ideal: 1920x1080px.')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('gallery_images')
                            ->label('Galeri Foto (JSON)')
                            ->helperText('Daftar URL gambar dalam format JSON. Contoh: ["url1","url2"]')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Deskripsi & Pengaturan Tampilan')
                    ->description('Atur bagaimana proyek ini muncul di halaman utama website.')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Proyek')
                            ->placeholder('Ceritakan tentang proyek ini secara singkat...')
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('size')
                            ->label('Ukuran Kartu')
                            ->options([
                                'large' => '🟩 Besar',
                                'small' => '🟨 Kecil',
                                'tall' => '🟦 Tinggi',
                                'wide' => '🟪 Lebar',
                            ])
                            ->helperText('Menentukan ukuran kartu proyek di halaman utama.'),
                        Forms\Components\TextInput::make('span')
                            ->label('Grid Span')
                            ->placeholder('contoh: md:col-span-7')
                            ->helperText('Pengaturan lebar kolom di grid (untuk developer).'),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->helperText('Angka lebih kecil = tampil lebih dulu.'),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Tampilkan di Halaman Utama?')
                            ->helperText('Aktifkan jika ingin proyek ini muncul di homepage.')
                            ->default(true),
                    ])->columns(2),
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
