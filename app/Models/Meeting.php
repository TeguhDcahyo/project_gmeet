<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'meeting_link', 
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($meeting) {
            $meeting->meeting_link = 'https://meet.google.com/mma-vvep-gju';
        });
    }

    // Cek apakah meeting sudah selesai
    public function isFinished(): bool
    {
        $endDateTime = Carbon::parse("{$this->date} {$this->end_time}");
        return $endDateTime->isPast();
    }
}
