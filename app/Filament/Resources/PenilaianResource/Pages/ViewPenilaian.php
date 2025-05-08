<?php

namespace App\Filament\Resources\PenilaianResource\Pages;

use App\Filament\Resources\PenilaianResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPenilaian extends ViewRecord
{
    protected static string $resource = PenilaianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
