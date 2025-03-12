<?php

// namespace App\Filament\Resources;

// use App\Models\Meeting;
// use Filament\Forms;
// use Filament\Tables;
// use Filament\Resources\Resource;
// use Filament\Forms\Components\TextInput;
// use Filament\Forms\Components\DatePicker;
// use Filament\Forms\Components\TimePicker;
// use Filament\Forms\Components\Select;
// use Filament\Tables\Columns\TextColumn;
// use Filament\Tables\Columns\ImageColumn;
// use Filament\Tables\Actions\EditAction;
// use Filament\Tables\Actions\DeleteAction;
// use App\Filament\Resources\MeetingResource\Pages;
// use Illuminate\Support\HtmlString;
// use Filament\Tables\Table;
// use Filament\Support\Enums\FontWeight;

// class MeetingResource extends Resource
// {
//     protected static ?string $model = Meeting::class;
//     protected static ?string $navigationIcon = 'heroicon-o-video-camera';
//     protected static ?string $navigationGroup = 'Meetings';

//     public static function form(Forms\Form $form): Forms\Form
//     {
//         return $form
//             ->schema([
//                 TextInput::make('title')->label('Judul Meeting')->required(),
//                 DatePicker::make('date')->label('Tanggal Meeting')->required(),
//                 TimePicker::make('start_time')->label('Jam Mulai')->required(),
//                 TimePicker::make('end_time')->label('Jam Selesai')->required(),
//                 Select::make('notification')
//                     ->label('Notifikasi')
//                     ->options([
//                         '5' => '5 Menit Sebelum',
//                         '10' => '10 Menit Sebelum',
//                         '30' => '30 Menit Sebelum',
//                     ])
//                     ->required(),
//                 TextInput::make('description')->label('Deskripsi Meeting')->required(),
//                 TextInput::make('participants')
//                     ->label('Peserta (Email)')
//                     ->required()
//                     ->placeholder('Pisahkan dengan koma'),
//             ]);
//     }

//     public static function table(Tables\Table $table): Tables\Table
// {
//     return $table
//     ->query(Meeting::query()->whereRaw(
//         "STR_TO_DATE(CONCAT(date, ' ', end_time), '%Y-%m-%d %H:%i:%s') >= NOW()"
//     ))
//     ->columns([
//         Tables\Columns\Layout\Split::make([
//             // **Bagian Kiri: Judul, Tanggal, Waktu, Tombol Join**
//             Tables\Columns\Layout\Stack::make([
//                 TextColumn::make('title')
//                     ->weight(FontWeight::Bold)
//                     ->size('lg')
//                     ->extraAttributes(['class' => 'text-xl text-gray-900']),
                
//                 TextColumn::make('date')
//                     ->label('Tanggal Meeting')
//                     ->formatStateUsing(fn ($state) => '📅 ' . \Carbon\Carbon::parse($state)->translatedFormat('d F Y'))
//                     ->extraAttributes(['class' => 'text-gray-700']),

//                 TextColumn::make('waktu_meeting')
//                     ->label('Waktu Meeting')
//                     ->state(fn ($record) => 
//                         $record->start_time && $record->end_time
//                             ? '⏰ ' . \Carbon\Carbon::parse($record->start_time)->format('H:i') .
//                               ' - ' .
//                               \Carbon\Carbon::parse($record->end_time)->format('H:i')
//                             : '⏰ Belum Ditentukan'
//                     )
//                     ->extraAttributes(['class' => 'text-gray-700']),

//                 // Tombol Join Meeting (sebagai TextColumn dengan HTML)
//                 TextColumn::make('join_meeting')
//                     ->formatStateUsing(fn (Meeting $record) => new HtmlString(
//                         '<a href="' . $record->meeting_link . '" 
//                             target="_blank" 
//                             class="filament-button bg-primary-600 text-white px-4 py-2 rounded-md shadow-md hover:bg-primary-700 transition">
//                             Join Meeting
//                         </a>'
//                     )),
//             ])->extraAttributes(['class' => 'space-y-1']),

//             // **Bagian Kanan: Deskripsi Meeting**
//             Tables\Columns\Layout\Stack::make([
//                 TextColumn::make('description')
//                     ->label('Deskripsi Meeting')
//                     ->limit(120) // Batasan karakter agar tampilan tetap rapi
//                     ->tooltip(fn ($state) => $state) // Tooltip untuk melihat deskripsi lengkap
//                     ->extraAttributes(['class' => 'text-gray-600 italic']),
//             ])->extraAttributes(['class' => 'flex justify-end items-center']),
//         ]),
//     ])
//         ->contentGrid([
//             'md' => 2,
//             'xl' 
//         ])
//         ->recordUrl(false)
//         ->paginationPageOptions([9, 18, 27])
//         ->filters([
//             Tables\Filters\Filter::make('title')
//                 ->form([
//                     Forms\Components\TextInput::make('title'),
//                 ])
//                 ->query(function ($query, array $data) {
//                     return $query->when(
//                         $data['title'] ?? null,
//                         fn ($query, $title) => $query->where('title', $title)
//                     );
//                 }),
//         ]);
// }


//     public static function getPages(): array
//     {
//         return [
//             'index' => Pages\ListMeetings::route('/'),
//             'create' => Pages\CreateMeeting::route('/create'),
//             'edit' => Pages\EditMeeting::route('/{record}/edit'),
//         ];
//     }
// }

namespace App\Filament\Resources;

use App\Models\Meeting;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use App\Filament\Resources\MeetingResource\Pages;
use Filament\Tables\Table;

class MeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;
    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static ?string $navigationGroup = 'Meetings';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
        ->schema([
            TextInput::make('title')->label('Judul Meeting')->required(),
            DatePicker::make('date')->label('Tanggal Meeting')->required(),
            TimePicker::make('start_time')->label('Jam Mulai')->required(),
            TimePicker::make('end_time')->label('Jam Selesai')->required(),
            Select::make('notification')
                ->label('Notifikasi')
                ->options([
                    '5' => '5 Menit Sebelum',
                    '10' => '10 Menit Sebelum',
                    '30' => '30 Menit Sebelum',
                ])
                ->required(),
            TextInput::make('description')->label('Deskripsi Meeting')->required(),
            TextInput::make('participants')
                ->label('Peserta (Email)')
                ->required()
                ->placeholder('Pisahkan dengan koma'),
        ]);
}

public static function table(Tables\Table $table): Tables\Table
{
    return $table
        ->query(Meeting::query()->whereRaw(
            "STR_TO_DATE(CONCAT(date, ' ', end_time), '%Y-%m-%d %H:%i:%s') >= NOW()"
        ))
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
                ->label('Tanggal Meeting')
                ->date()
                ->sortable()
                ->extraAttributes(['style' => 'width: 125px; text-align: center;']),

            TextColumn::make('start_time')
                ->label('Jam Mulai')
                ->time()
                ->extraAttributes(['style' => 'width: 100px; text-align: center;']),

            TextColumn::make('end_time')
                ->label('Jam Selesai')
                ->time()
                ->extraAttributes(['style' => 'width: 100px; text-align: center;']),
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
        ])
        ->actions([
            EditAction::make(),
            DeleteAction::make(),
        ]);
}



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeetings::route('/'),
            'create' => Pages\CreateMeeting::route('/create'),
            'edit' => Pages\EditMeeting::route('/{record}/edit'),
        ];
    }
}
