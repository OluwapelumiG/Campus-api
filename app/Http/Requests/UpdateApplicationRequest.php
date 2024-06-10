<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'gig_id' => 'sometimes|required|exists:gigs,id',
            'student_id' => 'sometimes|required|exists:users,id',
            'notes' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:applied,rejected,accepted',
        ];
    }
}
