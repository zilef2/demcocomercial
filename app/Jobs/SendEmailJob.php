<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $emailContent;
    protected string $emailSubject;

    /**
     * Create a new job instance.
     */
    public function __construct(string $emailContent,string $emailSubject = 'Correo de prueba desde Job')
    {
        $this->emailContent = $emailContent;
        $this->emailSubject = $emailSubject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::raw($this->emailContent, function ($message) {
            $message->to('ajelof2@gmail.com')
                    ->subject($this->emailSubject);
        });
    }
}
