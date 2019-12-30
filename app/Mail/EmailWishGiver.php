<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailWishGiver extends Mailable
{
    use Queueable, SerializesModels;
    private $receiver = null;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($receiver)
    {
        // User receiving the gift
        $this->receiver = $receiver;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Vous offrez ! Vous êtes au top !')
                    ->from('wishboxteam@wishbox.com', 'WishBox')
                    ->view('emails.wish_giver', ['user' => $this->receiver]);
    }
}
