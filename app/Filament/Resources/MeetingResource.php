<?php

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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use App\Filament\Resources\MeetingResource\Pages;
use Illuminate\Support\HtmlString;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;

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
            Tables\Columns\Layout\Split::make([
                // Bagian kiri (judul, tanggal, waktu meeting)
                Tables\Columns\Layout\Stack::make([
                    // Judul Meeting (dengan font besar & bold)
                    TextColumn::make('title')
                        ->weight(FontWeight::Bold)
                        ->size('lg')
                        ->extraAttributes(['class' => 'text-xl text-gray-900']),
                    
                    // Keterangan "Tanggal Meeting" + tanggalnya
                    TextColumn::make('date')
                        ->label('Tanggal Meeting')
                        ->formatStateUsing(fn ($state) => '📅 ' . \Carbon\Carbon::parse($state)->translatedFormat('d F Y'))
                        ->extraAttributes(['class' => 'text-gray-700']),

                    // Keterangan "Waktu Meeting" + Jam Mulai - Selesai
                    TextColumn::make('waktu_meeting')
    ->label('Waktu Meeting')
    ->state(fn ($record) => // Pakai state(), bukan formatStateUsing()
        $record->start_time && $record->end_time
            ? '⏰ ' . \Carbon\Carbon::parse($record->start_time)->format('H:i') .
              ' - ' .
              \Carbon\Carbon::parse($record->end_time)->format('H:i')
            : '⏰ Belum Ditentukan'
    )
    ->extraAttributes(['class' => 'text-gray-700']),

                    
                ])->extraAttributes(['class' => 'space-y-1'])->grow(),

                // Bagian kanan (tombol action)
                Tables\Columns\Layout\Stack::make([
                    TextColumn::make('detail_action')
                        ->formatStateUsing(fn (Meeting $resource) => new HtmlString(
                            '<a href="' . route('filament.admin.resources.meetings.view', $resource) . '" 
                                class="filament-button bg-primary-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-primary-600 transition">
                                🔍 Detail Peserta
                            </a>'
                        )),
                ])->extraAttributes(['class' => 'flex justify-end items-center'])->grow(false),
            ]),
        ])
        ->contentGrid([
            'md' => 2,
            'xl' => 3,
        ])
        ->recordUrl(false)
        ->paginationPageOptions([9, 18, 27])
        ->filters([
            Tables\Filters\Filter::make('title')
                ->form([
                    Forms\Components\TextInput::make('title'),
                ])
                ->query(function ($query, array $data) {
                    return $query->when(
                        $data['title'] ?? null,
                        fn ($query, $title) => $query->where('title', $title)
                    );
                }),
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
