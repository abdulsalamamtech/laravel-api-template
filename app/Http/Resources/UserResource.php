<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            // Load user role if user is admin
            // 'role' => $this->when($request->user()->role == 'admin', function () {
            //     return $this->role;
            'role' => $this->when($request->user()->role == 'admin', function () {
                return $this->role;
            }),
            'updated_at' => $this->updated_at->format('Y-m-d h:i:s'),
            'created_at' => $this->created_at->format('Y-m-d h:i:s'),
            // Load user post if available
            'posts' => PostResource::collection($this->whenLoaded('post'))
        ];
    }
}
