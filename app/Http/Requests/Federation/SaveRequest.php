<?php

namespace App\Http\Requests\Federation;

use App\Http\Requests\BaseRequest;

class SaveRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'logo' => ['nullable', 'image'],
            'name' => ['required', 'string'],
            'document_number' => ['nullable', 'string']
        ];
    }
}
