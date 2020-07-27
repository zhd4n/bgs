<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Participant.
 *
 * @property int $id
 * @property int|null $event_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Participant extends Model
{
    protected $fillable = [
      'event_id',
      'first_name',
      'last_name',
      'email',
    ];
}
