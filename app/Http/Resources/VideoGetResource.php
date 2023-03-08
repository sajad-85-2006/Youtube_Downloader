<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VideoGetResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $value = $this->collection;

        return [
            'data' => [
                'video' => $value[0],
                'quality' => $value[1]
            ]
        ];
    }
}
