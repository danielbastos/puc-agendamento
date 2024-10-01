<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'doctor_id' => ['required', 'integer'],
            'horarios' =>['required'],
            'horarios.*.a_date' =>['required', 'string'],
            'horarios.*.time_start' =>['required', 'string'],
            'horarios.*.time_end' =>['required', 'string'],
        ];
    }
}
