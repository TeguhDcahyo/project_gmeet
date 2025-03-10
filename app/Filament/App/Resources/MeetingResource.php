<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\MeetingResource\Pages;
use App\Models\Meeting;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class MeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([]); // Kosongkan form agar user di panel app tidak bisa membuat atau mengedit meeting
    }

    public static function table(Table $table): Table
    {
        return $table
        ->query(Meeting::whereRaw("STR_TO_DATE(CONCAT(date, ' ', end_time), '%Y-%m-%d %H:%i:%s') < NOW()"))    
        ->columns([
                Tables\Columns\TextColumn::make('title')->label('Judul Meeting')->sortable(),
                Tables\Columns\TextColumn::make('date')->label('Tanggal Meeting')->date(),
                Tables\Columns\TextColumn::make('start_time')->label('Jam Mulai')->time(),
                Tables\Columns\TextColumn::make('end_time')->label('Jam Selesai')->time(),
            ])
            ->filters([])
            ->actions([]) // Tidak ada aksi edit atau delete di panel app
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeetings::route('/'),
            // Hapus 'create' dan 'edit' agar user di panel app tidak bisa membuat atau mengedit meeting
        ];
    }

    public static function canCreate(): bool
    {
        return false; // Menonaktifkan tombol "Create Meeting"
    }

    public static function canEdit(Model $record): bool
    {
        return false; // Menonaktifkan tombol "Edit"
    }

    public static function canDelete(Model $record): bool
    {
        return false; // Menonaktifkan tombol "Delete"
    }
}
