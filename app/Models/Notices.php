<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Notices
 *
 * @property int $id
 * @property string $title
 * @property string|null $notice
 * @property string $notice_type available options: text, file, video
 * @property object $settings
 * @property int $active
 * @property string $target available options: all, program
 * @property int|null $program_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Notices newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notices newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notices onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Notices query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notices whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notices whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notices whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notices whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notices whereNotice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notices whereNoticeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notices whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notices whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notices whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notices whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notices whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notices withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Notices withoutTrashed()
 * @mixin \Eloquent
 */
class Notices extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "title",
        "notice",
        "notice_type",
        "settings",
        "active",
        "target",
        "program_id",
        "section_id",
    ];
    protected $casts = [
        "created_at" => "datetime",
        "updated_at" => 'datetime',
        "settings" => "object"
    ];

    const TYPES = [
        'text'  => 'Text',
        'image' => "Image / File",
        'video' => 'Video',
    ];
}
