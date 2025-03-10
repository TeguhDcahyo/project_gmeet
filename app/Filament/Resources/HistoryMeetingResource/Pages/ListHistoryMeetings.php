<?php

// namespace App\Filament\Resources\HistoryMeetingResource\Pages;

// use App\Filament\Resources\HistoryMeetingResource;
// use Filament\Actions;
// use Filament\Resources\Pages\ListRecords;

// class ListHistoryMeetings extends ListRecords
// {
//     protected static string $resource = HistoryMeetingResource::class;

//     protected function getHeaderActions(): array
//     {
//         return [
//             Actions\CreateAction::make(),
//         ];
//     }
// }

namespace App\Filament\Resources\HistoryMeetingResource\Pages;

use App\Filament\Resources\HistoryMeetingResource;
use Filament\Resources\Pages\ListRecords;

class ListHistoryMeetings extends ListRecords
{
    protected static string $resource = HistoryMeetingResource::class;
}