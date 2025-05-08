<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenilaianResource\Pages;
use App\Filament\Resources\PenilaianResource\RelationManagers;
use App\Models\Penilaian;
use App\Models\Karyawan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenilaianResource extends Resource
{
    protected static ?string $model = Penilaian::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationLabel = 'Penilaian Karyawan';
    protected static ?string $modelLabel = 'Penilaian';
    protected static ?string $pluralModelLabel = 'Penilaian Karyawan';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('karyawan_id')
                    ->label('Karyawan')
                    ->relationship('karyawan', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('penilai_id')
                    ->label('Penilai')
                    ->options(Karyawan::all()->pluck('nama', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\DatePicker::make('tanggal_penilaian')
                    ->label('Tanggal Penilaian')
                    ->required()
                    ->default(now()),

                Forms\Components\Select::make('nilai')
                    ->label('Nilai')
                    ->options([
                        1 => 'Sangat Buruk',
                        2 => 'Buruk',
                        3 => 'Cukup',
                        4 => 'Baik',
                        5 => 'Sangat Baik',
                    ])
                    ->required(),

                Forms\Components\Textarea::make('komentar')
                    ->label('Komentar')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('karyawan.nama')
                    ->label('Karyawan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('karyawan.departemen.nama')
                    ->label('Departemen')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_penilaian')
                    ->label('Tanggal Penilaian')
                    ->date()
                    ->sortable(),

                Tables\Columns\SelectColumn::make('nilai')
                    ->label('Nilai')
                    ->options([
                        1 => 'Sangat Buruk',
                        2 => 'Buruk',
                        3 => 'Cukup',
                        4 => 'Baik',
                        5 => 'Sangat Baik',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('nilai')
                    ->label('Nilai')
                    ->options([
                        1 => 'Sangat Buruk',
                        2 => 'Buruk',
                        3 => 'Cukup',
                        4 => 'Baik',
                        5 => 'Sangat Baik',
                    ]),

                Tables\Filters\Filter::make('tanggal_penilaian')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari_tanggal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_penilaian', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_penilaian', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPenilaians::route('/'),
            'create' => Pages\CreatePenilaian::route('/create'),
            'view' => Pages\ViewPenilaian::route('/{record}'),
            'edit' => Pages\EditPenilaian::route('/{record}/edit'),
        ];
    }
}
