<?php

namespace App\Http\Controllers;

use App\Events\ParticipantRegistered;
use App\Http\Requests\ParticipantRequest;
use App\Http\Resources\ParticipantResource;
use App\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $eventId = $request->has('event_id') ? (int) $request->input('event_id') : null;

        $participants = Participant::query()
            ->when($eventId, function ($query, $eventId) {
                return $query->where('event_id', $eventId);
            })
            ->get();

        return ParticipantResource::collection($participants);
    }

    public function store(ParticipantRequest $request)
    {
        $data = $request->validated();

        $participant = Participant::create($data);

        //Sending mail through event and listener
        //But of course we can use just Job class
        event(new ParticipantRegistered($participant));

        return (new ParticipantResource($participant))->response()->setStatusCode(201);
    }

    public function show(Participant $participant)
    {
        return new ParticipantResource($participant);
    }

    public function update(ParticipantRequest $request, Participant $participant)
    {

        $data = $request->validated();

        $participant->update($data);

        return new ParticipantResource($participant);
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();

        return response()->json(null, 204);
    }
}
