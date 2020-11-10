<?php

namespace App\Jobs;

use App\Mail\TestEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SimpleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;

    /**
     * Create a new job instance.
     *
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo $msg = "I will send an email to {$this->email}" . time() . PHP_EOL;
        try {
            $mailable = new TestEmail($this->email);
            Mail::to($this->email)->send($mailable);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
