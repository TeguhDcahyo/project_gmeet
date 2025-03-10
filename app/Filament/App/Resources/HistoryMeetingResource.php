<?php

namespace App\Filament\App\Resources;

use App\Models\Meeting;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn\Url;
use App\Filament\App\Resources\HistoryMeetingResource\Pages;

class HistoryMeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'Meetings';
    protected static ?string $label = 'Riwayat Meeting';

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(Meeting::whereRaw("STR_TO_DATE(CONCAT(date, ' ', end_time), '%Y-%m-%d %H:%i:%s') < NOW()"))
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Meeting')
                    ->sortable(),

                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date(),

                TextColumn::make('end_time')
                    ->label('Selesai pada')
                    ->time(),

                TextColumn::make('recording_url')
                    ->label('Rekaman')
                    ->formatStateUsing(fn (Meeting $record) => $record->recording_url 
                        ? "<a href='{$record->recording_url}' target='_blank' class='text-blue-500 underline'>Lihat Rekaman</a>"
                        : "Belum tersedia")
                    ->html(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHistoryMeetings::route('/'),
        ];
    }
}
