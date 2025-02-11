<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[A-Z][a-zA-Zа-яА-Я\s\d]*$/u'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[A-Z][a-zA-Zа-яА-Я\s\d]*$/u'],
            'patronymic' => ['required', 'string', 'max:255', 'regex:/^[A-Z][a-zA-Zа-яА-Я\s\d]*$/u'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'birth_date' => ['required', 'date_format:Y-m-d'],
        ];
    }
}
