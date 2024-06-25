<?php

namespace App\Http\Requests\Club;

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
            'federation_id' => ['required'],
            'name' => ['required', 'string'],
            'user_name' => ['required', 'string'],
            'user_phone' => ['nullable', 'string'],
            'user_email' => ['nullable', 'email'],
            'location' => ['nullable', 'string'],
            'region' => ['nullable', 'string'],
            'status' => ['required', 'in:active,passive']
        ];
    }

    public function attributes(): array
    {
        return [
            'federation_id' => __('clubs.form.federation_id'),
            'name' => __('clubs.form.name'),
            'user_name' => __('clubs.form.user_name'),
            'user_phone' => __('clubs.form.user_phone'),
            'user_email' => __('clubs.form.user_email'),
            'location' => __('clubs.form.location'),
            'region' => __('clubs.form.region'),
            'status' => __('clubs.form.status')
        ];
    }
}
