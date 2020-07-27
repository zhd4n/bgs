<?php

use App\Event;
use App\Participant;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Event::class, 5)->create()->each(function (Event $event) {
            $event->participants()->saveMany(factory(Participant::class, 5)->make());
        });
    }
}
