<?php

namespace App\Http\Requests;

use App\Rules\PublishedAt;
use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'        => 'required',
            'subtitle'     => 'nullable',
            'content'      => 'nullable',
            'published_at' => 'nullable',
        ];
    }
}
