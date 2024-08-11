<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleGigResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'category' => $this->category,
            'posted_by' => new UserResource($this->postedBy), // Assuming you have a UserResource
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'student_det' => $this->student,
        ];
    }
}
