<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSubmissionResource\Pages;
use App\Models\ContactSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';
    protected static ?string $navigationGroup = 'Inbox';
    protected static ?string $navigationLabel = 'Pesan Masuk';
    protected static ?string $modelLabel = 'Pesan';
    protected static ?string $pluralModelLabel = 'Pesan Masuk';
    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false; // Pesan hanya datang dari form website
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make('Message Context')
                        ->description('Communication details from the studio website.')
                        ->icon('heroicon-o-envelope')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Sender Name'),
                            Forms\Components\TextInput::make('email')
                                ->label('Email Address')
                                ->suffixIcon('heroicon-o-envelope'),
                            Forms\Components\TextInput::make('company')
                                ->label('Organization / Studio'),
                            Forms\Components\TextInput::make('budget')
                                ->label('Estimated Budget')
                                ->placeholder('—'),
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Timestamp')
                                ->content(fn($record) => $record?->created_at?->format('d M Y, H:i') ?? '-'),
                        ])->columns(2),
                    
                    Forms\Components\Section::make('The Inquiry')
                        ->icon('heroicon-o-chat-bubble-left-right')
                        ->schema([
                            Forms\Components\Textarea::make('message')
                                ->label('Message Content')
                                ->rows(12)
                                ->columnSpanFull(),
                        ])->grow(true),
                ])->columnSpanFull(),
            ])
            ->disabled();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Pengirim')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-o-envelope')
                    ->copyable()
                    ->copyMessage('Email disalin!'),
                Tables\Columns\TextColumn::make('company')
                    ->label('Perusahaan')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('budget')
                    ->label('Budget')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('message')
                    ->label('Pesan')
                    ->limit(30)
                    ->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diterima')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make()->label('Lihat'),
                Tables\Actions\DeleteAction::make()->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada pesan masuk')
            ->emptyStateDescription('Pesan dari pengunjung website akan muncul di sini.')
            ->emptyStateIcon('heroicon-o-inbox');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactSubmissions::route('/'),
            'view' => Pages\EditContactSubmission::route('/{record}'),
        ];
    }
}
