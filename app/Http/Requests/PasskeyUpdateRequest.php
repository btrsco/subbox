<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasskeyUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'alias' => ['required', 'string', 'min:3', 'max:48'],
        ];
    }
}
