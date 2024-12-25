<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\DharmasalaBookingLogs
 *
 * @property int $id
 * @property int $booking_id
 * @property array|null $original_content
 * @property array|null $changed_content
 * @property string|null $type available option: booking_status
 * @property array|null $original_type_value
 * @property array|null $change_type_value
 * @property string $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs query()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs whereChangeTypeValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs whereChangedContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs whereOriginalContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs whereOriginalTypeValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBookingLogs withoutTrashed()
 * @mixin \Eloquent
 */
class DharmasalaBookingLogs extends Model
{
    use HasFactory, SoftDeletes;

    protected  $fillable = [
        'booking_id',
        'original_content',
        'changed_content',
        'original_type_value',
        'change_type_value',
        'type',
        'updated_by'
    ];

    protected $casts = [
        'original_content'  => 'array',
        'changed_content'   => 'array',
        'original_type_value'   => 'array',
        'change_type_value' => 'array'
    ];
}
