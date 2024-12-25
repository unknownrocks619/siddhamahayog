<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProgramBatch
 *
 * @property int $id
 * @property string $program_id
 * @property string $batch_id
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Batch|null $batch
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramBatch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramBatch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramBatch onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramBatch query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramBatch whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramBatch whereBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramBatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramBatch whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramBatch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramBatch whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramBatch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramBatch withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramBatch withoutTrashed()
 * @mixin \Eloquent
 */
class ProgramBatch extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey='id';

    protected $table = 'program_batches';

    public $fillable = [
        "active",
        'program_id',
        'batch_id'
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class, "batch_id");
    }
}
