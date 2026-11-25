<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $mediaId = $this->route('medium');

        return [
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('media', 'title')->ignore($mediaId),
            ],
            'type' => 'sometimes|required|in:Movie,Series',
            'genre' => 'sometimes|required|string|max:255',
            'year' => 'sometimes|required|integer|digits:4',
            'duration' => 'sometimes|nullable|integer|min:1',
            'episodes' => 'sometimes|nullable|integer|min:1',
            'description' => 'nullable|string',
            'poster' => 'nullable|string|max:255',
        ];
    }
}
