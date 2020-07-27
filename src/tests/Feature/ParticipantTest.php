<?php

namespace Tests\Feature;

use App\Event;
use App\Listeners\SendWelcomeEmail;
use App\Participant;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ParticipantTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected function authenticate(): string
    {
        $user = factory(User::class)->create();

        return $user->createToken('api')->plainTextToken;
    }

    protected function getEvent(): Event
    {
        return factory(Event::class)->create();
    }

    /**
     * @param int $amount
     * @return Participant|Participant[]|Collection
     */
    protected function getParticipant(int $amount = null)
    {
        return factory(Participant::class, $amount)->create(['event_id' => $this->getEvent()->id]);
    }

    public function testParticipantCreatedSuccessfully()
    {
        Queue::fake();
        Queue::assertNothingPushed();

        $event = $this->getEvent();

        $data = [
            'event_id'   => $event->id,
            'first_name' => 'First Name',
            'last_name'  => 'Last Name',
            'email'      => 'some@email.com',
        ];

        //We can use Sanctum::actingAs as short alternative
        $token = $this->authenticate();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->postJson(route('participants.store'), $data, $headers);

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => array_merge(['id' => 1], $data),
            ]);

        Queue::assertPushed(function (CallQueuedListener $job) {
            return $job->class === SendWelcomeEmail::class;
        });
    }

    public function testParticipantEmailMustBeUnique()
    {
        $participant = $this->getParticipant();

        $data = [
            'event_id'   => $participant->event_id,
            'first_name' => 'Non Unique',
            'last_name'  => 'Same Email',
            'email'      => $participant->email,
        ];

        $token = $this->authenticate();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->postJson(route('participants.store'), $data, $headers);

        $response
            ->assertStatus(422)
            ->assertJsonPath('errors.email.0', 'The email has already been taken.');

    }

    public function testParticipantUpdatedSuccessfully()
    {
        $event = $this->getEvent();
        $participant = $this->getParticipant();

        $data = [
            'event_id'   => $event->id,
            'first_name' => 'New First Name',
            'last_name'  => 'New Last Name',
            'email'      => 'new.some@email.com',
        ];

        $token = $this->authenticate();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->putJson(route('participants.update', $participant), $data, $headers);

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => array_merge([
                    'id' => $participant->id,
                ], $data),
            ]);
    }

    public function testParticipantDeletedSuccessfully()
    {
        $participant = $this->getParticipant();

        $token = $this->authenticate();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->deleteJson(route('participants.destroy', $participant), [], $headers);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('participants', ['id' => $participant->id]);
    }

    public function testParticipantsListedSuccessfully()
    {
        $this->getParticipant(2);
        $participants = $this->getParticipant(5);

        $eventId = $participants->first()->event_id;

        $token = $this->authenticate();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->getJson(route('participants.index', ['event_id' => $eventId]), $headers);

        $response
            ->assertStatus(200)
            ->assertJsonCount(5, 'data');

        $responseUniqueEventIds = array_unique(array_column($response->json()['data'], 'event_id'));

        $this->assertCount(1, $responseUniqueEventIds);
        $this->assertSame($eventId, $responseUniqueEventIds[0]);
    }
}
