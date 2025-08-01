<?php

namespace App\Filament\Resources\FarmerApplicationResource\Pages;

use App\Filament\Resources\FarmerApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFarmerApplications extends ListRecords
{
    protected static string $resource = FarmerApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
