<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CurrencyExchange
 *
 * @property int $id
 * @property string $exchange_date
 * @property string $exchange_from
 * @property string $exchange_to
 * @property object|null $exchange_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyExchange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyExchange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyExchange onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyExchange query()
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyExchange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyExchange whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyExchange whereExchangeData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyExchange whereExchangeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyExchange whereExchangeFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyExchange whereExchangeTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyExchange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyExchange whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyExchange withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CurrencyExchange withoutTrashed()
 * @mixin \Eloquent
 */
class CurrencyExchange extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'exchange_date',
        'exchange_from',
        'exchange_to',
        'exchange_data'
    ];
    protected $casts = [
        'exchange_data' => 'object'
    ];


    public static function getExchangeRateByDate($date)
    {
        return Self::where('exchange_date', $date)->first();
    }
}
