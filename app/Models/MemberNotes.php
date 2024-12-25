<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MemberNotes
 *
 * @property int $id
 * @property int $member_id
 * @property string $title
 * @property string $slug
 * @property string|null $note
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotes query()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotes whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotes whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotes whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotes whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotes whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotes whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MemberNotes extends Model
{
    use HasFactory;
}
