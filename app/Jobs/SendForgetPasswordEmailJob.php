<?php

namespace App\Jobs;

use App\Mail\PasswordResetEmail; // ✅ Import the mailable
use Illuminate\Bus\Queueable; // ✅ Correct import for Queueable trait
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendForgetPasswordEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $details;

    /**
     * @param  array  $details  (contains token+email)
     */
    public function __construct(array $details)
    {
        $this->details = $details; // Save data for handle() method
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send the password reset email using the data
        Mail::to($this->details['email'])->send(
            new PasswordResetEmail($this->details)
        );
    }
}
