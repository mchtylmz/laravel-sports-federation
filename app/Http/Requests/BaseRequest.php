<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator, array $data = [])
    {
        $message = $validator->errors()->first() ?? __('auth.failed');

        throw new HttpResponseException(
            response()->json([
                'status'  => 'error',
                'message' => $message
            ], 401)
        );
    }
}
