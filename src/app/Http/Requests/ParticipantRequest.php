<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParticipantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $participantId = optional($this->route('participant'))->id;

        return [
            'event_id'   => ['required', 'integer', Rule::exists('events', 'id')],
            'first_name' => ['required', 'string', 'min:1', 'max:100'],
            'last_name'  => ['required', 'string', 'min:1', 'max:100'],
            'email'      => [
                'required',
                'email',
                Rule::unique('participants')
                    ->where('event_id', (int) $this->input('event_id'))
                    ->ignore($participantId),
            ],
        ];
    }
}
