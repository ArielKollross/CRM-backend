<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->load('columns');
        $resource = parent::toArray($request);

        $resource['id'] = $this->uuid;
        unset($resource['uuid']);

        return $resource;
    }
}
