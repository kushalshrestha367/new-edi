<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // allow public access
    }

    public function rules(): array
    {
        $rules = [
            'patient_name'           => ['required', 'string', 'max:255', 'regex:/^\S+\s+\S+/'], // at least 2 words
            'email'                  => ['nullable', 'email', 'max:255'],
            'phone' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9+\-\s\(\)]+$/'
            ], // numbers, +, -
            'appointment_date'       => ['required', 'date', 'after_or_equal:today'],
            'appointment_time'       => ['nullable', 'date_format:H:i'],
            'department_has_item_id' => ['nullable', 'exists:department_has_items,id'],
            'doctor_id'              => ['nullable', 'exists:members,id'],
            'notes'                  => ['nullable', 'string', 'max:1000'],
        ];

        return $rules;
    }
}
