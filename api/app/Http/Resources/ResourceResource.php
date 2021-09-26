<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResourceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $resource = [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'created_at' => date('Y-m-d H:i', strtotime($this->created_at))
        ];
        if($this->type === 'pdf')
        {
            $resource['pdf'] = new PdfResourceResource($this->resourceable);
        }
        else if($this->type === 'html')
        {
            $resource['html'] = new HtmlResourceResource($this->resourceable);
        }
        else if($this->type === 'link')
        {
            $resource['link'] = new LinkResourceResource($this->resourceable);
        }

        return $resource;
    }
}
