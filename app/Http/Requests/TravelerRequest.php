<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TravelerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'last_name' => ['required', 'max:250', 'string'],
            'first_name' => ['required', 'max:250', 'string'],
            'middle_name' => ['max:250', 'string'],
            'gender' => ['required', 'max:250', 'string'],
            'birth_date' => ['required', 'date'],
            'passport_number' => ['required', 'max:250', 'string'],
            'passport_place_issued' => ['required', 'max:250', 'string'],
            'passport_date_issued' => ['required', 'max:250', 'string'],
            'occupation' => ['required', 'max:250', 'string'],
            'contact_number' => ['required', 'max:250', 'string'],
            'philippines_address' => ['required', 'string'],
            'last_departure_date' => ['required', 'date'],
            'origin_country' => ['required', 'max:250', 'string'],
            'arrival_date' => ['required', 'date'],
            'flight_number' => ['required', 'max:250', 'string'],
            'remarks' => ['required', 'max:250', 'string'],
        ];
    }
}
