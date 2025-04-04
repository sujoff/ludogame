<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'external_id' => $this->external_id,
            'coins' => $this->coins,
            'gems' => $this->gems,
            'settings' => $this->settings,
            'statistics' => $this->statistics,
            'name' => $this->name,
            'firebase_id' => $this->firebase_id,
            'profile_image' => $this->profile_image,
            'skin_settings' => $this->skin_settings,
            'xp' => $this->xp,
        ];
    }
}
