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
    protected static ?string $navigationLabel = 'Press & Media';
    protected static ?string $modelLabel = 'Press Article';
    protected static ?string $pluralModelLabel = 'Press Coverage';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Press Insight')
                    ->description('Media coverage and editorial highlights for the studio.')
                    ->icon('heroicon-o-newspaper')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Article Headline')
                            ->required()
                            ->placeholder('e.g. Top 10 Emerging Architecture Firms'),
                        Forms\Components\TextInput::make('source')
                            ->label('Publication / Media')
                            ->required()
                            ->placeholder('e.g. Architectural Digest'),
                        Forms\Components\TextInput::make('url')
                            ->label('Original Link (URL)')
                            ->url()
                            ->placeholder('https://archdaily.com/...')
                            ->helperText('Direct link to the published article.'),
                        Forms\Components\DatePicker::make('published_at')
                            ->label('Publication Date'),
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
