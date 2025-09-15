<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyRegistrationEmail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendVerificationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

     public $user; // <-- Store the user object we get from controller
    /**
     * @param $user The registered user object
     * Create a new job instance.
     */
    public function __construct($user)
    {
        $this->user = $user; // Save user for use in handle()
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send the verification email
        Mail::to($this->user->email)->send(new VerifyRegistrationEmail($this->user));

    }
}
