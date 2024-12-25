<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Sadhana
 *
 * @property int $id
 * @property string $batch_id
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Sadhana newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sadhana newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sadhana query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sadhana whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sadhana whereBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sadhana whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sadhana whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sadhana whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sadhana whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sadhana extends Model
{
    use HasFactory;
}
