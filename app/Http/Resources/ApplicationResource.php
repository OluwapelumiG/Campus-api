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
            'id' => $this->id,
            // 'gig_id' => [
            //     'id' => $this->gig->id,
            //     'title' => $this->gig->title,
            //     'description' => $this->gig->description,
            //     'posted_by' => $this->gig->posted_by,
            //     // 'user' => new UserResource($this->gig->posted_by),
            //     'location' => $this->gig->location,
            //     'created_at' => $this->gig->created_at,
            // ],
            // 'owner' => new UserResource($this->owner),
            'gig_id' => new SimpleGigResource($this->gig),
            // 'gig_det' => $this->gig_det,
            // 'posted_by' => $this->owner,
            'student_id' => new UserResource($this->student),
            'notes' => $this->notes,
            'status' => $this->status,
            'created_at' => $this->created_at
        ];
    }
}
