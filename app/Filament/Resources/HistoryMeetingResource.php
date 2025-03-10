<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HistoryMeetingResource\Pages;
use App\Filament\Resources\HistoryMeetingResource\RelationManagers;
use App\Models\HistoryMeeting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;use App\Models\Meeting;
use Filament\Tables\Columns\TextColumn;
use Carbon\Carbon;

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
        ])
        ->actions([
            Tables\Actions\EditAction::make() // Hanya edit URL rekaman di History Meeting
                ->label('Tambah Rekaman'),
        ]);
    }

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('recording_url')
                ->label('URL Rekaman')
                ->url()
                ->required()
                ->placeholder('Masukkan link rekaman')
                ->columnSpanFull(),
        ]);
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHistoryMeetings::route('/'),
            'create' => Pages\CreateHistoryMeeting::route('/create'),
            'edit' => Pages\EditHistoryMeeting::route('/{record}/edit'),
        ];
    }
}
