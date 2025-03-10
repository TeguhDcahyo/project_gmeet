<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'start_time',
        'end_time',
        'notification',
        'description',
        'participants',
        'recording_url',
    ];

    // Cek apakah meeting sudah selesai
    public function isFinished(): bool
    {
        $endDateTime = Carbon::parse("{$this->date} {$this->end_time}");
        return $endDateTime->isPast();
    }
}
