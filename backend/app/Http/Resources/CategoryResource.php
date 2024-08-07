<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->routeIs('categories.index')) {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->description,
                'user_id' => $this->user->id,
                'user_name' => $this->user->name,
            ];
        } else {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->description,
                'user' => new UserResource($this->user),
            ];
        }
    }
}
