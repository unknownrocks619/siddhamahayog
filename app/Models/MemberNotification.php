<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MemberNotification
 *
 * @property int $id
 * @property int $member_id
 * @property string $title
 * @property string $body
 * @property string|null $notification_type attach a model from which notification was generated.
 * @property string|null $notification_id
 * @property string $type available option: model, message
 * @property string $level available optiosn: info, error, warning, notice
 * @property int $seen
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotification whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotification whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotification whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotification whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotification whereNotificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotification whereNotificationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotification whereSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MemberNotification extends Model
{
    protected $fillable = [
        "member_id",
        "title",
        "body",
        "notification_type",
        "notification_id",
        "type",
        "level",
        "seen"
    ];

    protected $casts = [
        "created_at" => 'datetime',
        "updated_at" => 'datetime'
    ];

    use HasFactory;
}
