<?php

use App\Jobs\SendNotificationsJob;
use Illuminate\Support\Facades\Schedule;

use Illuminate\Support\Facades\Artisan;



Schedule::job(new SendNotificationsJob)->everyMinute();


