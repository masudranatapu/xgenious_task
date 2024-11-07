<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'country_name',
    ];

    public function state()
    {
        return $this->hasMany(State::class);
    }
}
