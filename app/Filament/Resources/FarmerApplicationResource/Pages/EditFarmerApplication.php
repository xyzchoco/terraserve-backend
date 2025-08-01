<?php

namespace App\Filament\Resources\FarmerApplicationResource\Pages;

use App\Filament\Resources\FarmerApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFarmerApplication extends EditRecord
{
    protected static string $resource = FarmerApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
