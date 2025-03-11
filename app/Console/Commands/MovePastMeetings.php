<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Meeting;
use App\Models\HistoryMeeting;
use Carbon\Carbon;

class MovePastMeetings extends Command
{
    protected $signature = 'meetings:move-past';
    protected $description = 'Memindahkan meeting yang sudah selesai ke history_meetings';

    public function handle()
    {
        $pastMeetings = Meeting::whereRaw("STR_TO_DATE(CONCAT(date, ' ', end_time), '%Y-%m-%d %H:%i:%s') < NOW()")->get();

        foreach ($pastMeetings as $meeting) {
            HistoryMeeting::create([
                'title' => $meeting->title,
                'date' => $meeting->date,
                'start_time' => $meeting->start_time,
                'end_time' => $meeting->end_time,
                'recording_url' => $meeting->recording_url,
            ]);

            $meeting->delete();
        }

        $this->info('Meeting yang sudah selesai dipindahkan ke history.');
    }
}
