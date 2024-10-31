<?php

namespace App\Http\Requests\Onboarding;

use Illuminate\Foundation\Http\FormRequest;

class BlogStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'slug' => ['required', 'string', 'min:3', 'max:32', 'unique:blogs,slug'],
            'bio'  => ['nullable', 'string', 'max:1024'],
        ];
    }
}
