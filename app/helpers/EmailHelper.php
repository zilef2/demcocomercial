<?php

namespace App\helpers;

use App\Jobs\SendEmailJob;

class EmailHelper
{
    public static function sendEmailViaJob(string $content)
    {
        SendEmailJob::dispatch($content);
    }
}
