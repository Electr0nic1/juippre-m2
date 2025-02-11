<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpaceFlightsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'flight_number' => ['required', 'unique:space_flights', 'regex:/^[A-Z]*$/u'],
            'destination' => ['required', 'regex:/^[A-Z][a-zA-Zа-яА-Я\s\d]*$/u'],
            'launch_date' => ['required', 'date_format:Y-m-d'],
            'seats_available' => ['required', 'integer', 'min:1'],
        ];
    }
}
