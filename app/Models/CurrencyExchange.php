<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
