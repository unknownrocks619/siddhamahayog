<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ZoomMeeting
 *
 * @property int $id
 * @property string $zoom_accounts_id Foreign Key: Table: zoom_accounts
 * @property string $meeting_name
 * @property string $slug
 * @property string $meeting_type available options: scheduled:1,instant:2,re-occuring:3
 * @property int $daily_register
 * @property string|null $timezone zoom available timezone.
 * @property int $meeting_created
 * @property int $completed
 * @property string|null $scheduled_timestamp
 * @property string|null $repetition_setting
 * @property int $user_registered
 * @property int $live
 * @property int $lock
 * @property string|null $lock_setting
 * @property string|null $remarks
 * @property int|null $country_specified
 * @property string|null $meeting_by is nullable if meeting was created by admin.
 * @property string|null $created_by track who created this created.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\ZoomAccount|null $account
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting query()
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereCountrySpecified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereDailyRegister($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereLive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereLockSetting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereMeetingBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereMeetingCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereMeetingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereMeetingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereRepetitionSetting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereScheduledTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereUserRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ZoomMeeting whereZoomAccountsId($value)
 * @mixin \Eloquent
 */
class ZoomMeeting extends Model
{
    use HasFactory;

    public function account() {
        return $this->belongsTo(ZoomAccount::class,"zoom_account_id");
    }
}
