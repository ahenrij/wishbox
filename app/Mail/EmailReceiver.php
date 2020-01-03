<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailReceiver extends Mailable
{
    use Queueable, SerializesModels;
    private $giver;
    private $elementId;
    public $subject;
    private $type;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($giver, $elementId, $type, $subject)
    {
        // User giving the gift
        $this->giver = $giver;
        $this->elementId = $elementId;
        $this->type = $type;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
            return $this->subject($this->subject)
                ->from('wishboxteam@wishbox.com', 'WishBox')
                ->view('emails.'.$this->type.'_receiver', [
                    'user' => $this->giver,
                    'elementId' => $this->elementId]);
    }
}
