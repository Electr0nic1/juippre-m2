<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LunarMissionRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mission' => 'required',

            'mission.name' => 'required|regex:/^[A-ZА-ЯЁ][a-zA-Zа-яА-Я\s\d]*$/u',
            'mission.launch_details' => 'required',
            'mission.launch_details.launch_date' => 'required|date_format:Y-m-d',
            'mission.launch_details.launch_site' => 'required',
            'mission.launch_details.launch_site.name' => 'required',
            'mission.launch_details.launch_site.location' => 'required',
            'mission.launch_details.launch_site.location.latitude' => 'required|numeric|min:-90|max:90',
            'mission.launch_details.launch_site.location.longitude' => 'required|numeric|min:-180|max:180',

            'mission.landing_details' => 'required',
            'mission.landing_details.landing_date' => 'required|date_format:Y-m-d',
            'mission.landing_details.landing_site' => 'required',
            'mission.landing_details.landing_site.name' => 'required',
            'mission.landing_details.landing_site.coordinates' => 'required',
            'mission.landing_details.landing_site.coordinates.latitude' => 'required|numeric|min:-90|max:90',
            'mission.landing_details.landing_site.coordinates.longitude' => 'required|numeric|min:-180|max:180',

            'mission.spacecraft' => 'required',
            'mission.spacecraft.command_module' => 'required|string|max:255',
            'mission.spacecraft.lunar_module' => 'required|string|max:255',
            'mission.spacecraft.crew' => 'required|array',
            'mission.spacecraft.crew.*.name' => 'required',
            'mission.spacecraft.crew.*.role' => 'required',
        ];
    }
}
