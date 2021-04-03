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
            'coordinates' => 'required',
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


        try {
            $house = new House;
            $house->address = $request->address;
            $house->location = $request->location;
            $house->coordinates = $request->coordinates;
            $house->rent = $request->rent;
            $house->maxPeopleNum = $request->maxPeopleNum;
            $house->roomsNum = $request->roomsNum;
            $house->area = $request->area;
            $house->houseType = $request->houseType;
            $house->spaceType = $request->spaceType;
            $house->description = $request->description;
            $house->houseRules = $request->houseRules;

            $house->dateAvailable = $request->dateAvailable; //ano/mes/dia
            $house->save();
            
            //return successful response
            return response()->json(['house' => $house, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'addHouse Failed' + $e], 409);
        }

    }

    public function getAllHouses(Request $request)
    {   

         return response()->json(['users' =>  House::all()], 200);
    }

    public function getHouseById($id)
    {
        try {
            $house = House::findOrFail($id);

            return response()->json(['house' => $house], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'house not found!'], 404);
        }

    }

    public function updateHouse(Request $request){ //recebe id da house
        $house = House::where('id' , '=' , $request->houseId)->first();

        //so altera o que receber no request (filled)
        if ($request->filled('address')){
            $house->address = $request->address;
        }
        if ($request->filled('location')){
            $house->location = $request->location;
        }
        if ($request->filled('coordinates')){
            $house->coordinates = $request->coordinates;
        }
        if ($request->filled('rent')){
            $house->rent = $request->rent;
        }
        if ($request->filled('maxPeopleNum')){
            $house->maxPeopleNum = $request->maxPeopleNum;
        }
        if ($request->filled('roomsNum')){
            $house->roomsNum = $request->roomsNum;
        }
        if ($request->filled('area')){
            $house->area = $request->area;
        }
        if ($request->filled('houseType')){
            $house->houseType = $request->houseType;
        }
        if ($request->filled('spaceType')){
            $house->spaceType = $request->spaceType;
        }
        if ($request->filled('description')){
            $house->description = $request->description;
        }
        if ($request->filled('houseRules')){
            $house->houseRules = $request->houseRules;
        }
        if ($request->filled('dateAvailable')){
            $house->dateAvailable = $request->dateAvailable;
        }

        if(!$house->save()) {
            throw new HttpException(500);
        }
        else {
            return response()->json([
                'status' => 'House Updated'
            ], 200);
        }
    }


    public function deleteHouseById($id)
    {
        $house = House::findOrFail($id);

        if(!$house->delete()) {
            throw new HttpException(500);
        }
        else {
            return response()->json([
                'status' => 'House deleted'
            ], 200);
        }

    }

}
