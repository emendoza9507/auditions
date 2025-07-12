<?php

namespace App\Filament\Resources\AuditionResource\Pages;

use App\Filament\Resources\AuditionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAuditions extends ListRecords
{
    protected static string $resource = AuditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
