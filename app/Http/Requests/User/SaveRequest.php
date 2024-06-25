<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class SaveRequest extends BaseRequest
{

    protected function prepareForValidation(): void
    {
        $this->merge([
            'username' => Str::slug($this->username),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'name' => ['required', 'string'],
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'password' => ['nullable', 'string', Password::min(6)],
            'status' => ['required', 'in:active,passive'],
            'identity_number' => ['nullable', 'string'], // 'required_if:role,manager'
            'places' => ['required_if:role,manager'],
            'federation_id' => ['required_if:role,admin'],
            'event_color' => ['hex_color'],
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => __('users.form.username'),
            'name' => __('users.form.name'),
            'phone' => __('users.form.phone'),
            'email' => __('users.form.email'),
            'password' => __('users.form.password'),
            'status' => __('table.status'),
            'role' => __('users.form.role'),
            'places' => __('users.form.places'),
            'identity_number' => __('users.form.identity_number'),
            'federation_id' => __('table.federation'),
            'event_color' => __('users.form.event_color'),
        ];
    }
}
