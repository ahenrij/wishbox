<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailGiver extends Mailable
{
    use Queueable, SerializesModels;
    /** @var User $giver */
    private $giver;
    private $elementId;
    public $subject;
    private $type;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $giver, $elementId, $type, $subject)
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
            ->view('emails.'.$this->type.'_giver', [
                'user' => $this->giver,
                'elementId' => $this->elementId]);
    }

}
