<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'type'     => $this->type,
            'genre'    => $this->genre,
            'score'    => $this->score,
            'episodes' => $this->episodes,
            'vibe'     => $this->vibe,
            // hanya tampil kalau relasi sudah di-load (eager loading)
            'users'    => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
