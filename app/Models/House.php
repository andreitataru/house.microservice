<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address', 'location', 'coordenates', 'rent', 'maxPeopleNum', 'roomsNum', 'area', 'houseType', 'spaceType', 
        'description', 'houseRules', 'rating', 'timesRated', 'dateAvailable'
    ];

}
