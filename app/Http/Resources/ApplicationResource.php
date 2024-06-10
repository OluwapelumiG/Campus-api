<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return [
            'gig_id' => [
                'id' => $this->gig->id,
                'title' => $this->gig->title,
            ],
//            'gig_id' => new GigResource($this->gig),
            'student_id' => new UserResource($this->student),
            'notes' => $this->notes,
            'status' => $this->status
        ];
    }
}
