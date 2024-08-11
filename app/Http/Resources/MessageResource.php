<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'from' => User::find($this->from),
            'user_id' => User::find($this->user_id),
            'message' => $this->message,
            'read' => $this->read,
            'replying' => $this->replying,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
