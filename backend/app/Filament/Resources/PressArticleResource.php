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
    protected static ?string $navigationLabel = 'Pers & Media';
    protected static ?string $modelLabel = 'Artikel Pers';
    protected static ?string $pluralModelLabel = 'Liputan Pers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Wawasan Pers')
                    ->compact()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Artikel')
                            ->required()
                            ->placeholder('contoh: Top 10 Emerging Architecture Firms'),
                        Forms\Components\TextInput::make('source')
                            ->label('Publikasi / Media')
                            ->required()
                            ->placeholder('contoh: Architectural Digest'),
                        Forms\Components\TextInput::make('url')
                            ->label('Tautan Asli (URL)')
                            ->url()
                            ->placeholder('https://archdaily.com/...')
                            ->helperText('Tautan langsung ke artikel yang diterbitkan.'),
                        Forms\Components\DatePicker::make('published_at')
                            ->label('Tanggal Terbit'),
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
            ->striped()
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
        ];
    }
}
