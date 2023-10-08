<?php

namespace App\Http\Requests;

use Carbon\Carbon;
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
            'gender' => ['max:250'],
            'birth_date' => ['required', 'date'],
            'passport_number' => ['max:250'],
            'passport_place_issued' => ['max:250'],
            // 'passport_date_issued' => ['date'],
            'occupation' => ['max:250'],
            'contact_number' => ['max:250'],
            'philippines_address' => ['max:250'],
            // 'last_departure_date' => ['sometimes', 'date'],
            'origin_country' => ['max:250'],
            'arrival_date' => ['required', 'date'],
            'flight_number' => ['required', 'max:250', 'string'],
            'airline' => ['required', 'max:250', 'string'],
            'traveler_type' => ['max:250'],
            'travel_purpose' => ['max:250'],
            'remarks' => ['required', 'max:250', 'string'],
            'findings' => ['max:250'],
            'amount' => ['max:250'],
            'company' => ['max:250'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (request()->has('last_departure_date')) {
                try {
                    $last_departure_date = request('last_departure_date');
                    Carbon::parse($last_departure_date);
                } catch (\Exception $e) {
                    $validator->errors()->add('last_departure_date', 'The last departure date is not a valid date.');
                }
            }
            if (request()->has('passport_date_issued')) {
                try {
                    $passport_date_issued = request('passport_date_issued');
                    Carbon::parse($passport_date_issued);
                } catch (\Exception $e) {
                    $validator->errors()->add('passport_date_issued', 'The passport date issued is not a valid date.');
                }
            }
        });
    }
}
