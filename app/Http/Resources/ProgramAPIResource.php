<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramAPIResource extends JsonResource
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
            "program_id" => $this->id,
            "program_name" => $this->program_name,
            "slug" => $this->slug,
            "program_type" => $this->type,
            "description" => $this->description,
            "zoom" => $this->zoom,
            "status" => $this->status
        ];
        return parent::toArray($request);
    }
}
