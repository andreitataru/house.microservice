<?php

namespace App\Http\Controllers;
use App\Models\House;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function addHouse(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'address' => 'required',
            'location' => 'required',
            'coordenates' => 'required',
            'rent' => 'required',
            'maxPeopleNum' => 'required',
            'roomsNum' => 'required',
            'area' => 'required',
            'houseType' => 'required',
            'spaceType' => 'required',
            'description' => 'required',
            'houseRules' => 'required',
            'dateAvailable' => 'required',
        ]);

    }

}
