<?php

namespace App\Filament\Resources\HistoryMeetingResource\Pages;

use App\Filament\Resources\HistoryMeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHistoryMeeting extends EditRecord
{
    protected static string $resource = HistoryMeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
