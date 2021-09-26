<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HtmlResourceResource extends JsonResource
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
            'description' => $this->description,
            'snippet' => $this->snippet
        ];
    }
}
