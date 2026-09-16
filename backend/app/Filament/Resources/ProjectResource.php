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
                        Forms\Components\Section::make('Informasi Utama')
                            ->compact()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul Proyek')
                                    ->required()
                                    ->placeholder('contoh: The Void House')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('the-void-house'),
                                Forms\Components\TextInput::make('category')
                                    ->label('Kategori')
                                    ->required()
                                    ->placeholder('contoh: Residensial'),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('location')
                                            ->label('Lokasi Proyek')
                                            ->placeholder('contoh: Kotagede, Yogyakarta atau Banggai, Sulteng'),
                                        Forms\Components\Select::make('status')
                                            ->label('Status Pengerjaan')
                                            ->options([
                                                'Completed' => 'Completed (Selesai)',
                                                'In Progress' => 'In Progress (Sedang Dikerjakan)',
                                                'Under Construction' => 'Under Construction (Konstruksi)',
                                                'Concept' => 'Concept / Planning (Konsep)',
                                            ])
                                            ->default('Completed')
                                            ->required(),
                                    ]),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('client')
                                            ->label('Nama Klien')
                                            ->placeholder('Klien Pribadi'),
                                        Forms\Components\TextInput::make('year')
                                            ->label('Tahun Selesai')
                                            ->placeholder('2025'),
                                    ]),
                                Forms\Components\TagsInput::make('team_in_charge')
                                    ->label('Team in Charge (Arsitek & Tim Bertanggung Jawab)')
                                    ->placeholder('Ketik nama arsitek & tekan Enter')
                                    ->helperText('Daftar nama arsitek/tim yang mengerjakan proyek ini. Ketik nama lalu tekan Enter.')
                                    ->separator(','),
                                Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi Proyek')
                                    ->placeholder('Ceritakan kisah di balik arsitektur ini...')
                                    ->rows(6),
                            ])->columnSpan(2),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\Section::make('Narasi Visual')
                                    ->compact()
                                    ->schema([
                                        Forms\Components\FileUpload::make('hero_image')
                                            ->label('Gambar Utama (Hero)')
                                            ->image()
                                            ->directory('projects/hero')
                                            ->required()
                                            ->helperText('Visual lanskap resolusi tinggi (disarankan 16:9). Unggah file langsung dari perangkat Anda.'),
                                    ]),

                                Forms\Components\Section::make('Grid & Kurasi')
                                    ->compact()
                                    ->schema([
                                        Forms\Components\Select::make('size')
                                            ->label('Proporsi Kartu')
                                            ->options([
                                                'large' => 'Besar (Lebar Penuh)',
                                                'small' => 'Kecil (Standar)',
                                                'tall' => 'Tinggi (Potret)',
                                                'wide' => 'Lebar (Horizontal)',
                                            ])
                                            ->default('small'),
                                        Forms\Components\TextInput::make('span')
                                            ->label('Lebar Grid (Tailwind)')
                                            ->placeholder('md:col-span-6'),
                                        Forms\Components\TextInput::make('sort_order')
                                            ->label('Urutan')
                                            ->numeric()
                                            ->default(0),
                                        Forms\Components\Toggle::make('is_featured')
                                            ->label('Tampilkan di Beranda')
                                            ->inline(false)
                                            ->default(true),
                                    ]),
                            ])->columnSpan(1),
                    ]),

                Forms\Components\Section::make('Koleksi Galeri')
                    ->compact()
                    ->schema([
                        Forms\Components\FileUpload::make('gallery_images')
                            ->label('Unggah Foto Galeri Proyek')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->directory('projects/gallery')
                            ->helperText('Pilih satu atau banyak foto langsung dari komputer Anda. Anda dapat mengatur ulang urutan foto dengan drag & drop.'),
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
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'Completed' => 'success',
                        'In Progress' => 'warning',
                        'Under Construction' => 'info',
                        default => 'gray',
                    })
                    ->toggleable(),
                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun'),
                Tables\Columns\TextInputColumn::make('sort_order')
                    ->label('Urutan')
                    ->type('number')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_featured')
                    ->label('Featured'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->striped()
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Status Featured'),
            ])
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
        ];
    }
}
