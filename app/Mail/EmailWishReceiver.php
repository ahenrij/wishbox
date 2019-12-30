<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailWishReceiver extends Mailable
{
    use Queueable, SerializesModels;
    private $giver = null;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($giver)
    {
        // User giving the gift
        $this->giver = $giver;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Il suffisait de demander.')
                    ->from('wishboxteam@wishbox.com', 'WishBox')
                    ->view('emails.wish_receiver', ['user' => $this->giver]);
    }
}
