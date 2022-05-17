<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramStudentAPIResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $text = ucwords(strtolower($this->first_name));
        if ($this->middle_name) {
            $text .= " " . ucwords(strtolower($this->middle_name));
        }
        $text .= " " . ucwords(strtolower($this->last_name));
        return [
                "id" => $this->id,
                "text" => $text
        ];
        return parent::toArray($request);
    }
}
