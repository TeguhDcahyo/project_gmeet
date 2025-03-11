protected function schedule(Schedule $schedule)
{
    $schedule->command('meetings:move-past')->dailyAt('00:00');
}
