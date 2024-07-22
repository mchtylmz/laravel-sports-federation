<?php

namespace App\Http\Requests\Federation;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class DirectorSaveRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string'],
            'name' => ['required'],
            'surname' => ['required'],
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'string', 'email'],
            'identity' => ['nullable', 'string'],
            'sort' => ['required', 'numeric'],
        ];
    }
}
