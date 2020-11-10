<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationLinkEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $hash;

    /**
     * InvitationLinkEmail constructor.
     * @param string $email
     * @param string $hash
     */
    public function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.verification', [
            'hash' => $this->hash
        ]);
    }
}
