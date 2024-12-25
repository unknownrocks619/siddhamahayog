<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\UserSadhanaLevel
 *
 * @property int $id_usl
 * @property int $user_id
 * @property int $charan_usl
 * @property int $upacharan_usl
 * @property string|null $charan_date_usl
 * @property string|null $upacharan_date_usl
 * @property \Illuminate\Support\Carbon|null $created_by_usl
 * @property \Illuminate\Support\Carbon $created_at_usl
 * @property \Illuminate\Support\Carbon $updated_at_usl
 * @property \Illuminate\Support\Carbon|null $deleted_at_usl
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel whereCharanDateUsl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel whereCharanUsl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel whereCreatedAtUsl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel whereCreatedByUsl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel whereDeletedAtUsl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel whereIdUsl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel whereUpacharanDateUsl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel whereUpacharanUsl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel whereUpdatedAtUsl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserSadhanaLevel withoutTrashed()
 * @mixin \Eloquent
 */
class UserSadhanaLevel extends Model
{
    use HasFactory,SoftDeletes;

    const CREATED_AT = 'created_at_usl';
    const UPDATED_AT = 'updated_at_usl';
    const DELETED_AT = 'deleted_at_usl';

    protected $table = 'user_sadhana_levels_usl';
    protected $primaryKey = 'id_usl';

    protected $fillable = [
            'user_id',
            'charan_usl',
            'upacharan_usl',
            'charan_date_usl',
            'upacharan_date_usl',
            'created_by_usl'
    ];

    protected $casts = [
        'created_by_usl'    => 'date'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
