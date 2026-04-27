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

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Perusahaan';
    protected static ?string $navigationLabel = 'Anggota Tim';
    protected static ?string $modelLabel = 'Anggota Tim';
    protected static ?string $pluralModelLabel = 'Anggota Tim';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Profil')
                    ->compact()
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->placeholder('contoh: Alexander Chen'),
                                Forms\Components\TextInput::make('role')
                                    ->label('Peran Studio')
                                    ->required()
                                    ->placeholder('contoh: Lead Architect'),
                            ]),
                        Forms\Components\Textarea::make('bio')
                            ->label('Biografi / Narasi')
                            ->placeholder('Jelaskan perjalanan kreatif dan keahliannya...')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])->columnSpan(2),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Identitas Visual')
                            ->compact()
                            ->schema([
                                Forms\Components\FileUpload::make('photo')
                                    ->label('Foto Potret')
                                    ->image()
                                    ->directory('team')
                                    ->helperText('Foto potret berkualitas tinggi. Disarankan grayscale untuk konsistensi brand.'),
                            ]),

                        Forms\Components\Section::make('Manajemen')
                            ->compact()
                            ->schema([
                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Urutan Tampilan')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Angka lebih rendah muncul lebih dulu.'),
                            ]),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->square(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('role')
                    ->label('Peran')
                    ->searchable()
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextInputColumn::make('sort_order')
                    ->label('Urutan')
                    ->type('number')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->striped()
            ->filters([
                //
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
        ];
    }
}
