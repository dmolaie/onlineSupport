<?php

namespace App\Listeners\Email;

use App\Events\Email\EmailNotifyEvent;
use App\Mail\Question;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class EmailNotifyListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param EmailNotifyEvent $event
     * @return void
     */
    public function handle(EmailNotifyEvent $event)
    {
        new Question($event->dataDTO);
    }
}
