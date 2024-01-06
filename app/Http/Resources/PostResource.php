<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => (string) $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'body' => $this->body,
            'updated_at' => $this->updated_at->format('Y-m-d h:i:s'),
            'created_at' => $this->created_at->format('Y-m-d h:i:s'),
            // Load user if available
            'author' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
