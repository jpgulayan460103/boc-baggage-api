<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelerCompanion extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'birth_date',
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

    public function traveler(){
        return $this->belongsTo(Traveler::class);
    }
}
