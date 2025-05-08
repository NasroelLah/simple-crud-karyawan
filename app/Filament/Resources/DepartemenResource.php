<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartemenResource\Pages;
use App\Filament\Resources\DepartemenResource\RelationManagers;
use App\Models\Departemen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartemenResource extends Resource
{
    protected static ?string $model = Departemen::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Departemen';
    protected static ?string $modelLabel = 'Departemen';
    protected static ?string $pluralModelLabel = 'Departemen';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),

                Forms\Components\Textarea::make('keterangan')
                    ->nullable()
                    ->maxLength(1000)
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('status')
                    ->required()
                    ->default(true)
                    ->label('Status Aktif')
                    ->onColor('success')
                    ->offColor('danger'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('keterangan')
                    ->limit(50)
                    ->searchable(),

                Tables\Columns\IconColumn::make('status')
                    ->boolean()
                    ->sortable()
                    ->label('Status'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Dibuat Pada')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Diperbarui Pada')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        true => 'Aktif',
                        false => 'Tidak Aktif',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\KaryawanRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDepartemens::route('/'),
            'create' => Pages\CreateDepartemen::route('/create'),
            'edit' => Pages\EditDepartemen::route('/{record}/edit'),
        ];
    }
}
