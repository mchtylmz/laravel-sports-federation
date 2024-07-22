<?php

namespace App\Http\Requests\Event;

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
            'title' => ['required', 'string'],
            'content' => ['nullable', 'string'],
            'location' => ['required', 'string'],
            'is_national' => ['in:0,1'],
            'start_date' => ['date'],
            'start_time' => ['date_format:H:i'],
            'end_date' => ['date'],
            'end_time' => ['date_format:H:i'],
            'end_notes' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => __('events.form.title'),
            'content' => __('events.form.content'),
            'location' => __('events.form.location'),
            'is_national' => __('events.form.is_national'),
            'start_date' => __('events.form.start_date'),
            'start_time' => __('events.form.start_time'),
            'end_date' => __('events.form.end_date'),
            'end_time' => __('events.form.end_time'),
            'end_notes' => __('events.form.end_notes'),
            'status' => 'Durum'
        ];
    }
}
