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
                    Forms\Components\Section::make('Konteks Pesan')
                        ->compact()
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Pengirim'),
                            Forms\Components\TextInput::make('email')
                                ->label('Alamat Email')
                                ->suffixIcon('heroicon-o-envelope'),
                            Forms\Components\TextInput::make('company')
                                ->label('Organisasi / Studio'),
                            Forms\Components\TextInput::make('budget')
                                ->label('Estimasi Budget')
                                ->placeholder('—'),
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Waktu Kirim')
                                ->content(fn($record) => $record?->created_at?->format('d M Y, H:i') ?? '-'),
                        ])->columns(2),
                    
                    Forms\Components\Section::make('Isi Pesan')
                        ->compact()
                        ->schema([
                            Forms\Components\Textarea::make('message')
                                ->label('Konten Pesan')
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
                    ->label('Anggaran')
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
            ->striped()
            ->actions([
                Tables\Actions\Action::make('reply')
                    ->label('Balas')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(fn (ContactSubmission $record): string => "https://mail.google.com/mail/?view=cm&fs=1&to={$record->email}&su=Balasan: Pesan dari {$record->name}")
                    ->openUrlInNewTab()
                    ->iconButton()
                    ->tooltip('Balas via Gmail'),
                Tables\Actions\ViewAction::make()
                    ->iconButton()
                    ->tooltip('Lihat')
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
            ->emptyStateHeading('Belum ada pesan masuk')
            ->emptyStateDescription('Pesan dari pengunjung website akan muncul di sini.')
            ->emptyStateIcon('heroicon-o-inbox');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactSubmissions::route('/'),
        ];
    }
}
