<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MeetingProgram
 *
 * @property int $id
 * @property string $meeting_id
 * @property string $program_id
 * @property int $is_live
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingProgram newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingProgram newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingProgram query()
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingProgram whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingProgram whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingProgram whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingProgram whereIsLive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingProgram whereMeetingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingProgram whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingProgram whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MeetingProgram extends Model
{
    use HasFactory;
}
