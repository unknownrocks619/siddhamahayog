<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RedirectionSchema
 *
 * @property int $id
 * @property string $member_id
 * @property string|null $views
 * @property string|null $title
 * @property string $type
 * @property string|null $modal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|RedirectionSchema newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RedirectionSchema newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RedirectionSchema query()
 * @method static \Illuminate\Database\Eloquent\Builder|RedirectionSchema whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedirectionSchema whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedirectionSchema whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedirectionSchema whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedirectionSchema whereModal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedirectionSchema whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedirectionSchema whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedirectionSchema whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RedirectionSchema whereViews($value)
 * @mixin \Eloquent
 */
class RedirectionSchema extends Model
{
    use HasFactory;
}
