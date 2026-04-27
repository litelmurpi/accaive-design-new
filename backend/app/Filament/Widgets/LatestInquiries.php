<?php

namespace App\Filament\Widgets;

use App\Models\ContactSubmission;
use App\Filament\Resources\ContactSubmissionResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestInquiries extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactSubmission::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->color('gray'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Pengirim')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope'),
                Tables\Columns\TextColumn::make('budget')
                    ->label('Anggaran')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('message')
                    ->label('Isi Pesan')
                    ->limit(50),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn (): string => ContactSubmissionResource::getUrl('index'))
                    ->icon('heroicon-o-inbox')
                    ->label('Buka Inbox'),
            ]);
    }
}
