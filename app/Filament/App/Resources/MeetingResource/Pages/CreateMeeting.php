<?php

namespace App\Filament\App\Resources\MeetingResource\Pages;

use App\Filament\App\Resources\MeetingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMeeting extends CreateRecord
{
    protected static string $resource = MeetingResource::class;
}
