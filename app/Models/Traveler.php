<?php

namespace App\Models;

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
}
