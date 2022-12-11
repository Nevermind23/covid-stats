<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'name' => 'array'
    ];

    protected $with = [
        'statistic'
    ];

    public function statistic(): HasOne
    {
        return $this->hasOne(Statistic::class);
    }
}
