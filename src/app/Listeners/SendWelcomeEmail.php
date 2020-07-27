<?php

namespace App\Listeners;

use App\Events\ParticipantRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Log\LogManager;

class SendWelcomeEmail implements ShouldQueue
{
    /**
     * @var LogManager
     */
    private $log;

    public function __construct(LogManager $log)
    {
        $this->log = $log->channel('participants');
    }

    public function handle(ParticipantRegistered $event): void
    {
        $this->log->info('Here we can send welcome email to participant #'.$event->participant->id);
    }
}
