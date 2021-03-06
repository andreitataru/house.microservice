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
        'hostId', 'address', 'location', 'coordinates', 'rent', 'maxPeopleNum', 'roomsNum', 'area', 'houseType', 'spaceType', 
        'description', 'commodities', 'houseRules', 'installations', 'rating', 'timesRated', 'dateAvailable', 'pictures'
    ];

}
