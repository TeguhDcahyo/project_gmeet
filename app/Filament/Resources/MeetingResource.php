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
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use App\Filament\Resources\MeetingResource\Pages;

class MeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
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
            ->columns([
                TextColumn::make('title')->label('Judul Meeting')->sortable(),
                TextColumn::make('date')->label('Tanggal')->date(),
                TextColumn::make('start_time')->label('Jam Mulai')->time(),
                TextColumn::make('end_time')->label('Jam Selesai')->time(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
