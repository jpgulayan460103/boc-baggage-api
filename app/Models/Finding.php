<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finding extends Model
{
    use HasFactory;

    protected $fillable = [
        'goods_description',
        'goods_quantity',
        'goods_value',
        'traveler_id',
    ];

    public function traveler() {
        return $this->belongsTo(Traveler::class);
    }
}
