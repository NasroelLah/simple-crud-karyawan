<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CutiResource\Pages;
use App\Filament\Resources\CutiResource\RelationManagers;
use App\Models\Cuti;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CutiResource extends Resource
{
    protected static ?string $model = Cuti::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Pengajuan Cuti';
    protected static ?string $modelLabel = 'Pengajuan Cuti';
    protected static ?string $pluralModelLabel = 'Pengajuan Cuti';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('karyawan_id')
                    ->relationship('karyawan', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\DatePicker::make('tanggal_mulai')
                    ->required(),

                Forms\Components\DatePicker::make('tanggal_selesai')
                    ->required()
                    ->after('tanggal_mulai'),

                Forms\Components\Select::make('jenis_cuti')
                    ->options([
                        'cuti_tahunan' => 'Cuti Tahunan',
                        'cuti_besar' => 'Cuti Besar',
                        'cuti_sakit' => 'Cuti Sakit',
                        'cuti_lainnya' => 'Cuti Lainnya',
                    ])
                    ->required(),

                Forms\Components\Textarea::make('alasan')
                    ->required()
                    ->maxLength(65535),

                Forms\Components\Toggle::make('status')
                    ->label('Status Persetujuan')
                    ->helperText('Aktifkan untuk menyetujui, nonaktifkan untuk menolak')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('karyawan.nama')
                    ->label('Nama Karyawan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_selesai')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenisCutiLabel')
                    ->label('Jenis Cuti'),

                Tables\Columns\TextColumn::make('alasan')
                    ->limit(20)
                    ->tooltip(function ($record): string {
                        return $record->alasan;
                    }),

                Tables\Columns\IconColumn::make('status')
                    ->boolean()
                    ->label('Status Persetujuan')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('statusLabel')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Disetujui' => 'success',
                        'Ditolak' => 'danger',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->label('Tanggal Pengajuan')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_cuti')
                    ->options([
                        'cuti_tahunan' => 'Cuti Tahunan',
                        'cuti_besar' => 'Cuti Besar',
                        'cuti_sakit' => 'Cuti Sakit',
                        'cuti_lainnya' => 'Cuti Lainnya',
                    ])
                    ->label('Jenis Cuti'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        '1' => 'Disetujui',
                        '0' => 'Ditolak',
                    ])
                    ->label('Status Persetujuan'),
                Tables\Filters\SelectFilter::make('karyawan_id')
                    ->relationship('karyawan', 'nama')
                    ->searchable()
                    ->preload()
                    ->label('Karyawan'),
                Tables\Filters\Filter::make('tanggal_mulai')
                    ->form([
                        Forms\Components\DatePicker::make('tanggal_dari')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('tanggal_sampai')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tanggal_dari'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_mulai', '>=', $date),
                            )
                            ->when(
                                $data['tanggal_sampai'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_mulai', '<=', $date),
                            );
                    })
                    ->label('Tanggal Mulai'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn(Cuti $record) => !$record->status)
                    ->action(function (Cuti $record) {
                        $record->update(['status' => true]);
                    })
                    ->requiresConfirmation(),
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn(Cuti $record) => $record->status)
                    ->action(function (Cuti $record) {
                        $record->update(['status' => false]);
                    })
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()->label('Export ke Excel'),
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
            'index' => Pages\ListCutis::route('/'),
            'create' => Pages\CreateCuti::route('/create'),
            'edit' => Pages\EditCuti::route('/{record}/edit'),
        ];
    }
}
