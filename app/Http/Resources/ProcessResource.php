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

        unset($resource['id']);

        foreach ($resource['columns'] as $key => $column) {
            unset($resource['columns'][$key]['id']);
            unset($resource['columns'][$key]['process_id']);
        }

        return $resource;
    }
}
