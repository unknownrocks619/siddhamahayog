<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SystemSetting
 *
 * @property int $id
 * @property string $email_verification
 * @property string $phone_verification
 * @property string $complex_password
 * @property string $corn_job
 * @property string $auto_responder
 * @property string $cache
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSetting whereAutoResponder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSetting whereCache($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSetting whereComplexPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSetting whereCornJob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSetting whereEmailVerification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSetting wherePhoneVerification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemSetting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemSetting extends Model
{
    use HasFactory;
}
