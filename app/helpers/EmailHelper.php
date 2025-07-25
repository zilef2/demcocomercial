<?php

namespace App\Helpers;

use App\Jobs\SendEmailJob;

class EmailHelper
{
    public static function sendEmailViaJob(string $content)
    {
        SendEmailJob::dispatch($content);
    }
}
