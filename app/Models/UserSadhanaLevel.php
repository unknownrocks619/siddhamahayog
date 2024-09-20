<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
