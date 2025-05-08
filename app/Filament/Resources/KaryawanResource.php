<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KaryawanResource\Pages;
use App\Filament\Resources\KaryawanResource\RelationManagers;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

use App\Models\Karyawan;
use App\Models\Departemen;
use App\Models\Jabatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KaryawanResource extends Resource
{
    protected static ?string $model = Karyawan::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Karyawan';
    protected static ?string $modelLabel = 'Data Karyawan';
    protected static ?string $pluralModelLabel = 'Data Karyawan';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nik')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_hp')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\Textarea::make('alamat')
                    ->maxLength(65535),
                Forms\Components\DatePicker::make('tanggal_lahir'),
                Forms\Components\Select::make('jenis_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->required(),
                Forms\Components\Select::make('departemen_id')
                    ->label('Departemen')
                    ->options(Departemen::where('status', true)->pluck('nama', 'id'))
                    ->required()
                    ->searchable(),
                Forms\Components\Select::make('jabatan_id')
                    ->label('Jabatan')
                    ->options(Jabatan::where('status', true)->pluck('nama', 'id'))
                    ->required()
                    ->searchable(),
                Forms\Components\FileUpload::make('foto')
                    ->image(),
                Forms\Components\Toggle::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp'),
                Tables\Columns\TextColumn::make('departemen.nama')
                    ->label('Departemen')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jabatan.nama')
                    ->label('Jabatan')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('foto'),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),
                Tables\Filters\SelectFilter::make('departemen')
                    ->relationship('departemen', 'nama'),
                Tables\Filters\SelectFilter::make('jabatan')
                    ->relationship('jabatan', 'nama'),
                Tables\Filters\TernaryFilter::make('status')
                    ->label('Status'),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->headerActions([
                ExportAction::make('export'),
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
            'index' => Pages\ListKaryawans::route('/'),
            'create' => Pages\CreateKaryawan::route('/create'),
            'edit' => Pages\EditKaryawan::route('/{record}/edit'),
        ];
    }
}
