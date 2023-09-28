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
            'middle_name' => ['max:250'],
            'gender' => ['required', 'max:250', 'string'],
            'birth_date' => ['required', 'date'],
            'passport_number' => ['required', 'max:250'],
            'passport_place_issued' => ['max:250'],
            'passport_date_issued' => ['required', 'date'],
            'occupation' => ['max:250'],
            'contact_number' => ['max:250'],
            // 'philippines_address' => ['string'],
            'last_departure_date' => ['required', 'date'],
            'origin_country' => ['max:250'],
            'arrival_date' => ['required', 'date'],
            'flight_number' => ['required', 'max:250', 'string'],
            'remarks' => ['required', 'max:250', 'string'],
        ];
    }
}
