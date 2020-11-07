<?php

namespace App\Jobs;

use App\Models\EmailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

final class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    public $emailMessage;

    /**
     * Create a new job instance.
     *
     * @param EmailMessage $emailMessage
     */
    public function __construct(EmailMessage $emailMessage)
    {
        $this->emailMessage = $emailMessage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Log::info("test " . $this->emailMessage->id);
        Log::info($this->job->maxTries());

    }


}
