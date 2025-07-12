<?php

namespace App\Filament\Resources\AuditionRegistrationResource\Pages;

use App\Filament\Resources\AuditionRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAuditionRegistrations extends ListRecords
{
    protected static string $resource = AuditionRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
