<?php

namespace App\Http\Requests\Punishment;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

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
            'people_id' => ['required', 'exists:App\Models\People,id'],
            'reason' => ['required', 'string'],
            'description' => ['nullable', 'string']
        ];
    }
}
