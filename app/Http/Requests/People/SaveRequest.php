<?php

namespace App\Http\Requests\People;

use App\Enums\Gender;
use App\Enums\PeopleType;
use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'type' => ['required', Rule::in(PeopleType::values())],
            'gender' => ['required', Rule::in(Gender::values())],
            'photo' => ['nullable', 'image'],
            'federation_id' => ['nullable', 'integer'],
            'license_no' => ['required', 'string'],
            'name' => ['required', 'string'],
            'surname' => ['required', 'string'],
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'nationality' => ['nullable', 'string'],
            'identity' => ['nullable', 'string'],
            'birth_place' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date:Y-m-d'],
            'adult' => ['nullable', 'in:0,1,2'],
            'father_name' => ['nullable', 'string'],
            'licensed_at' => ['nullable', 'date:Y-m-d'],
            'registered_at' => ['nullable', 'date:Y-m-d'],
            'status' => ['nullable', 'in:active,passive'],
        ];
    }
}
