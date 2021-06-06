<?php

namespace App\Http\Controllers;
use App\Models\House;
use App\Models\Interest;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use DB;

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
            'title' => 'required',
            'hostId' => 'required',
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
            'dateAvailable' => 'required',
        ]);
        
        try {
            $house = new House;
            $house->title = $request->title;
            $house->hostId = $request->hostId;
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

            if ($request->filled("closeServices")){
                $house->closeServices = $request->closeServices;
            }

            if ($request->filled("commodities")){
                $house->commodities = $request->commodities;
            }
            if ($request->filled("houseRules")){
                $house->houseRules = $request->houseRules;
            }
            if ($request->filled("installations")){
                $house->installations = $request->installations;
            }
            $house->dateAvailable = $request->dateAvailable; //ano/mes/dia
            
            $house->save();
            
            if ($request->filled("pictures")){
                $pathToMake = "uploads/houses/" . $house->id;
                if(!File::isDirectory($pathToMake)){
                    File::makeDirectory($pathToMake, 0777, true, true);
                    $picturesList = explode(" ", $request->pictures);
                    $id = 0;
                    foreach ($picturesList as $file) {
                        $path = $pathToMake . "/" . $id . ".jpeg";
                        Image::make(file_get_contents($file))->save($path); 
                        if ($house->pictures == ""){
                            $house->pictures = url('/') . '/' . $path;
                        }
                        else {
                            $house->pictures = $house->pictures . " " . url('/') . '/' . $path;
                        }
                        $house->save();
                        $id++;
                    }
                }
            }
            
            
            //return successful response
            return response()->json(['house' => $house, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'addHouse Failed' + $e], 409);
        }

    }

    public function getAllHouses(Request $request)
    {   

         return response()->json(['houses' =>  House::all()], 200);
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
        if ($request->filled('title')){
            $house->title = $request->title;
        }
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
        if ($request->filled('closeServices')){
            $house->closeServices = $request->closeServices;
        }
        if ($request->filled('commodities')){
            $house->commodities = $request->commodities;
        }
        if ($request->filled('houseRules')){
            $house->houseRules = $request->houseRules;
        }
        if ($request->filled('installations')){
            $house->installations = $request->installations;
        }
        if ($request->filled('dateAvailable')){
            $house->dateAvailable = $request->dateAvailable;
        }
        if ($request->filled('picture')){
            $picture = explode(" ", $request->picture);
            $id = $picture[0];
            $base64 = $picture[1];
            $path = "uploads/houses/" . $request->houseId . "/" . $id . ".jpg";
            Image::make(file_get_contents($base64))->save($path); 

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

    public function getHousesWithFilter(Request $request)
    {
        $houses = House::all();

        if ($request->filled('address')){
            $houses = DB::table('houses')
            ->where(DB::raw('lower(address)'), 'like', '%' . strtolower($request->address) . '%')->get();
        }
        if ($request->filled('location')){
            $houses = DB::table('houses')
            ->where(DB::raw('lower(location)'), 'like', '%' . strtolower($request->location) . '%')->get();
        }
        if ($request->filled('rent')){
            $houses = $houses->where('rent', '<=', $request->rent);
        }
        if ($request->filled('maxPeopleNum')){
            $houses = $houses->where('maxPeopleNum', '<=', $request->maxPeopleNum);
        }
        if ($request->filled('roomsNum')){
            $houses = $houses->where('roomsNum', '<=', $request->roomsNum);
        }
        if ($request->filled('area')){
            $houses = $houses->where('area', $request->area);
        }
        if ($request->filled('houseType')){
            $houses = $houses->where('houseType', $request->houseType);
        }
        if ($request->filled('spaceType')){
            $houses = $houses->where('spaceType', $request->spaceType);
        }
        if ($request->filled('rating')){
            $houses = $houses->where('rating', '>=' ,$request->rating);
        }
        if ($request->filled('commodities')){
            $commodities = explode(' ', $request->commodities);
            foreach ($houses as $key =>$house){
                foreach ($commodities as &$com) {
                    if(!str_contains($house->commodities, $com)){
                        unset($houses[$key]);    
                    }
                }
            }
        }
        if ($request->filled('houseRules')){
            $houseRules = explode(' ', $request->houseRules);
            foreach ($houses as $key =>$house){
                foreach ($houseRules as &$hr) {
                    if(!str_contains($house->houseRules, $hr)){
                        unset($houses[$key]);    
                    }
                }
            }
        }
        if ($request->filled('installations')){
            $installations = explode(' ', $request->installations);
            foreach ($houses as $key =>$house){
                foreach ($installations as &$inst) {
                    if(!str_contains($house->installations, $inst)){
                        unset($houses[$key]);    
                    }
                }
            }
        }
 
        return $houses;

    }

    public function getHousesWithOwnerId($id)
    {
        $houses = House::where('hostId', $id)->get();
        return response()->json(['houses' => $houses], 200);
    }

    public function addInterest(Request $request)
    {

        //validate incoming request 
        $this->validate($request, [
            'idInterested' => 'required',
            'idHouse' => 'required',
            'personName' => 'required',

        ]);
        
        try {
            $interest = new Interest;
            $interest->idInterested = $request->idInterested;
            $interest->idHouse = $request->idHouse;
            $interest->personName = $request->personName;
            $interest->save();
            
            //return successful response
            return response()->json(['interest' => $interest, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'addInterest Failed' + $e], 500);
        }
    }

    public function getInterestsByHouseId($id)
    {
        try {
            $interests = Interest::where('idHouse', $id)->get();

            return response()->json(['interests' => $interests], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'interests not found!'], 404);
        }
    }

    public function getInterestsByUserId($id)
    {
        try {
            $interests = Interest::where('idInterested', $id)->get();

            return response()->json(['interests' => $interests], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'interests not found!'], 404);
        }
    }

}
