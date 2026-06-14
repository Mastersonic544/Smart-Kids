<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Run the SaaS subscription lifecycle once a day at 06:00 server time.
Schedule::command('subscriptions:process')->dailyAt('06:00');
