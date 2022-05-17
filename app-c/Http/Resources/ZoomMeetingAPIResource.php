<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ZoomMeetingAPIResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            "zoome_accounts_id" => $this->account->account_name,
            "name" => $this->meeting_name,
            "type" => $this->meeting_type,
            "timezone" => $this->timezone,
            "meeting_scheduled_time" => $this->scheduled_timestamp,
            "reoccuring_setting" => $this->repetition_setting,
            "lock" => $this->lock,
            "lock_interval" => $this->lock_setting
        ];
        // return parent::toArray($request);
    }
}
