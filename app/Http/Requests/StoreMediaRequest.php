<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:media,title',
            'type' => 'required|in:Movie,Series',
            'genre' => 'required|string|max:255',
            'year' => 'required|integer|digits:4',
            'duration' => 'nullable|integer|min:1',
            'episodes' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'poster' => 'nullable|string|max:255',
        ];
    }
}
