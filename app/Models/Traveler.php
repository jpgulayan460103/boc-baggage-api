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
        'airline',
        'findings',
        'amount',
        'traveler_type',
        'travel_purpose',
        'company',
    ];

    protected $dates = [
        'birth_date',
        'passport_date_issued',
        'last_departure_date',
        'arrival_date',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->fullname = $model->first_name." ".$model->middle_name." ".$model->last_name;
        });
        self::updating(function ($model) {
            $model->fullname = $model->first_name." ".$model->middle_name." ".$model->last_name;
        });
    }

    

    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = $value ? Carbon::parse($value) : null;
    }

    public function setLastDepartureDateAttribute($value)
    {
        $this->attributes['last_departure_date'] = $value ? Carbon::parse($value) : null;
    }

    public function setPassportDateIssuedAttribute($value)
    {
        $this->attributes['passport_date_issued'] = $value ? Carbon::parse($value) : null;
    }

    public function setArrivalDateAttribute($value)
    {
        $this->attributes['arrival_date'] = $value ? Carbon::parse($value) : null;
    }

    public function getCreatedAtAttribute($value)
    {
        if($value){
            return Carbon::createFromTimestamp(strtotime($value))
            ->timezone(config('app.timezone'))
            ->format('m/d/Y h:i:s A');
        }else{
            return "";
        }
    }

    public function getBirthDateAttribute($value)
    {
        if($value){
            return Carbon::createFromTimestamp(strtotime($value))
            ->timezone(config('app.timezone'))
            ->format('m/d/Y');
        }else{
            return "";
        }
    }
    public function getPassportDateIssuedAttribute($value)
    {
        if($value){
            return Carbon::createFromTimestamp(strtotime($value))
            ->timezone(config('app.timezone'))
            ->format('m/d/Y');
        }else{
            return "";
        }
    }
    public function getLastDepartureDateAttribute($value)
    {
        if($value){
            return Carbon::createFromTimestamp(strtotime($value))
            ->timezone(config('app.timezone'))
            ->format('m/d/Y');
        }else{
            return "";
        }
    }
    public function getArrivalDateAttribute($value)
    {
        if($value){
            return Carbon::createFromTimestamp(strtotime($value))
            ->timezone(config('app.timezone'))
            ->format('m/d/Y');
        }else{
            return "";
        }
    }

    public function customFindings() {
        return $this->hasMany(Finding::class);
    }

    public function companions() {
        return $this->hasMany(TravelerCompanion::class);
    }
    
}
