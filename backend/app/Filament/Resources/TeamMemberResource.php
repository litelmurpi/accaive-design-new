<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamMemberResource\Pages;
use App\Filament\Resources\TeamMemberResource\RelationManagers;
use App\Models\TeamMember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Company';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Profile Information')
                    ->description('Personal details and studio role.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->placeholder('e.g. Alexander Chen'),
                                Forms\Components\TextInput::make('role')
                                    ->label('Studio Role')
                                    ->required()
                                    ->placeholder('e.g. Lead Architect'),
                            ]),
                        Forms\Components\Textarea::make('bio')
                            ->label('Biography / Narrative')
                            ->placeholder('Describe the creative journey and expertise...')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])->columnSpan(2),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Visual Identity')
                            ->description('Studio portrait.')
                            ->icon('heroicon-o-camera')
                            ->schema([
                                Forms\Components\FileUpload::make('photo')
                                    ->label('Portrait Photo')
                                    ->image()
                                    ->directory('team')
                                    ->helperText('High-quality portrait. Grayscale recommended for brand consistency.'),
                            ]),

                        Forms\Components\Section::make('Management')
                            ->schema([
                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Display Order')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Lower numbers appear first in the team grid.'),
                            ]),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Portrait')
                    ->square(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->searchable()
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeamMembers::route('/'),
            'create' => Pages\CreateTeamMember::route('/create'),
            'edit' => Pages\EditTeamMember::route('/{record}/edit'),
        ];
    }
}
