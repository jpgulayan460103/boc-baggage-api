<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Traveler extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'gender',
        'birth_date',
        'citizenship',
        'passport_number',
        'passport_place_issued',
        'passport_date_issued',
        'occupation',
        'contact_number',
        'philippines_address',
        'last_departure_date',
        'origin_country',
        'arrival_date',
        'flight_number',
        'remarks',
    ];

    protected $dates = [
        'birth_date',
        'passport_date_issued',
        'last_departure_date',
        'arrival_date',
    ];
    

    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = Carbon::parse($value);
    }

    public function setLastDepartureDateAttribute($value)
    {
        $this->attributes['last_departure_date'] = Carbon::parse($value);
    }

    public function setPassportDateIssuedAttribute($value)
    {
        $this->attributes['passport_date_issued'] = Carbon::parse($value);
    }

    public function setArrivalDateAttribute($value)
    {
        $this->attributes['arrival_date'] = Carbon::parse($value);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))
        ->timezone(config('app.timezone'))
        ->format('m/d/Y h:i:s A');
    }

    public function getBirthDateAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))
        ->timezone(config('app.timezone'))
        ->format('m/d/Y');
    }
    public function getPassportDateIssuedAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))
        ->timezone(config('app.timezone'))
        ->format('m/d/Y');
    }
    public function getLastDepartureDateAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))
        ->timezone(config('app.timezone'))
        ->format('m/d/Y');
    }
    public function getArrivalDateAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))
        ->timezone(config('app.timezone'))
        ->format('m/d/Y');
    }
    
}
