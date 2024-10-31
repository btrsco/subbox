<?php

namespace App\Http\Requests\Onboarding;

use Illuminate\Foundation\Http\FormRequest;

class SubscriberStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subscriber_1' => ['nullable', 'email'],
            'subscriber_2' => ['nullable', 'email'],
            'subscriber_3' => ['nullable', 'email'],
            'subscriber_4' => ['nullable', 'email'],
            'subscriber_5' => ['nullable', 'email'],
        ];
    }
}
