<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class GigResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'category' => $this->category,
            //            'posted_by' => [
            //                'id' => $this->user->id,
            //                'name' => $this->user->name,
            //                'email' => $this->user->email,
            //            ],
            'posted_by' => new UserResource($this->postedBy), // Assuming you have a UserResource
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // 'student' => $this->student ?? null,
            'student_det' => $this->student_det ?? null,
            'price' => $this->price,
            'applications' => ApplicationResource::collection($this->applications),
        ];
    }
}

//            'posted_by' => [
//                'id' => $this->user->id,
//                'name' => $this->user->name,
////                'email' => $this->user->email,
//            ],
//            'student' => [
//                'id' => $this->user->id,
//                'name' => $this->user->name,
////                'email' => $this->user->email,
//            ],
