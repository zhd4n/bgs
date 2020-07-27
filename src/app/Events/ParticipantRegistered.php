<?php

namespace App\Events;

use App\Participant;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParticipantRegistered
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * @var Participant
     */
    public $participant;

    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }
}
