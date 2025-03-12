<?php

// namespace App\Filament\App\Resources;

// use App\Models\Meeting;
// use Filament\Resources\Resource;
// use Filament\Tables;
// use Filament\Tables\Table;
// use Filament\Tables\Columns\TextColumn;
// use Carbon\Carbon;
// use Filament\Tables\Columns\TextColumn\Url;
// use App\Filament\App\Resources\HistoryMeetingResource\Pages;

// class HistoryMeetingResource extends Resource
// {
//     protected static ?string $model = Meeting::class;
//     protected static ?string $navigationIcon = 'heroicon-o-clock';
//     protected static ?string $navigationGroup = 'Meetings';
//     protected static ?string $label = 'Riwayat Meeting';

//     public static function table(Tables\Table $table): Tables\Table
//     {
//         return $table
//             ->query(Meeting::whereRaw("STR_TO_DATE(CONCAT(date, ' ', end_time), '%Y-%m-%d %H:%i:%s') < NOW()"))
//             ->columns([
//                 TextColumn::make('title')
//                     ->label('Judul Meeting')
//                     ->sortable(),

//                 TextColumn::make('date')
//                     ->label('Tanggal')
//                     ->date(),

//                 TextColumn::make('end_time')
//                     ->label('Selesai pada')
//                     ->time(),

//                 TextColumn::make('recording_url')
//                     ->label('Rekaman')
//                     ->formatStateUsing(fn (Meeting $record) => $record->recording_url 
//                         ? "<a href='{$record->recording_url}' target='_blank' class='text-blue-500 underline'>Lihat Rekaman</a>"
//                         : "Belum tersedia")
//                     ->html(),
//             ]);
//     }

//     public static function getPages(): array
//     {
//         return [
//             'index' => Pages\ListHistoryMeetings::route('/'),
//         ];
//     }
// }


namespace App\Filament\App\Resources;

use App\Models\Meeting;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms;
use Carbon\Carbon;
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
                    ->sortable()
                    ->searchable()
                    ->extraAttributes(['style' => 'width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;']),

                TextColumn::make('description')
                    ->label('Deskripsi Meeting')
                    ->limit(100)
                    ->tooltip(fn ($state) => $state)
                    ->extraAttributes(['style' => 'width: 300px; white-space: normal; word-wrap: break-word;']),

                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable()
                    ->extraAttributes(['style' => 'width: 125px; text-align: center;']),

                TextColumn::make('end_time')
                    ->label('Selesai pada')
                    ->time()
                    ->extraAttributes(['style' => 'width: 100px; text-align: center;']),

                TextColumn::make('recording_url')
                    ->label('Rekaman')
                    ->formatStateUsing(fn (Meeting $record) => $record->recording_url 
                        ? "<a href='{$record->recording_url}' target='_blank' class='text-blue-500 underline'>Lihat Rekaman</a>"
                        : "Belum tersedia")
                    ->html(),
            ])
            ->filters([
                Tables\Filters\Filter::make('title')
                    ->label('Cari Judul Meeting')
                    ->form([
                        Forms\Components\TextInput::make('title')
                            ->placeholder('Masukkan judul meeting...')
                            ->live()
                            ->debounce(500),
                    ])
                    ->query(fn ($query, array $data) => 
                        $query->when($data['title'] ?? null, fn ($query, $title) => 
                            $query->where('title', 'like', "%{$title}%")
                        )
                    ),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHistoryMeetings::route('/'),
        ];
    }
}
