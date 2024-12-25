<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Reference
 *
 * @property int $id
 * @property int $referenced_by
 * @property int $referenced_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Reference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reference onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Reference query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reference whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reference whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reference whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reference whereReferencedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reference whereReferencedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reference whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reference withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Reference withoutTrashed()
 * @mixin \Eloquent
 */
class Reference extends Model
{
    use HasFactory, SoftDeletes;
}
