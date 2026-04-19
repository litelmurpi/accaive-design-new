<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PressArticleResource\Pages;
use App\Models\PressArticle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PressArticleResource extends Resource
{
    protected static ?string $model = PressArticle::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'Liputan Media';
    protected static ?string $modelLabel = 'Artikel Pers';
    protected static ?string $pluralModelLabel = 'Liputan Media';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Artikel')
                    ->description('Artikel atau liputan media tentang Accaive yang tampil di halaman "Press".')
                    ->icon('heroicon-o-newspaper')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Artikel')
                            ->required()
                            ->placeholder('contoh: Top 10 Emerging Architecture Firms'),
                        Forms\Components\TextInput::make('source')
                            ->label('Nama Media / Sumber')
                            ->required()
                            ->placeholder('contoh: Architectural Digest, Dezeen'),
                        Forms\Components\TextInput::make('url')
                            ->label('Link Artikel (URL)')
                            ->url()
                            ->placeholder('contoh: https://archdaily.com/article/...')
                            ->helperText('Link menuju artikel asli di website media.'),
                        Forms\Components\DatePicker::make('published_at')
                            ->label('Tanggal Terbit')
                            ->helperText('Kapan artikel ini dipublikasikan?'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('source')
                    ->label('Media')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Artikel')
                    ->searchable()
                    ->weight('bold')
                    ->wrap()
                    ->limit(60),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal Terbit')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada liputan media')
            ->emptyStateDescription('Klik tombol "Buat Artikel Pers" untuk menambah liputan.')
            ->emptyStateIcon('heroicon-o-newspaper');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPressArticles::route('/'),
            'create' => Pages\CreatePressArticle::route('/create'),
            'edit' => Pages\EditPressArticle::route('/{record}/edit'),
        ];
    }
}
