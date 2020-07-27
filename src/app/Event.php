<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Event.
 *
 * @property int $id
 * @property string $title
 * @property string $city
 * @property string|null $starts_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Participant[] $participants
 * @property int|null $participants_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }
}
