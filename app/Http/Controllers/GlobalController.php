<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;


use App\Models\Place;
use App\Models\PlaceComment;
use App\Models\PlaceGrade;
use App\Models\PlaceSubgrade;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Question;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rule;


class GlobalController extends Controller
{

    public $place_id;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function getAll($edit_id = '')
    {

        if (backpack_auth()->check()) {
            

            $allPlaces = Place::all();

            $allGrades = Grade::all();


            return view(
                'home',
                compact(
                    'userid',
                    'allPlaces',
                    'allGrades'
                )
            );
        
        } else {
            return view('index');
        }
    }
    

   

    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // in meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance;
    }
    

    static function comments()
    {
        $comments = PlaceComment::all();
        return $comments;
    }

    static function places()
    {
        $places = Place::all();
        return $places;
    }

    static function categories()
    {
        $categories = Category::all();
        return $categories;
    }

    static function subcategories()
    {
        $subcategories = Subcategory::all();
        return $subcategories;
    }

    static function questions()
    {
        $questions = Question::all();
        return $questions;
    }

    


    //----------------------new code----------------------


    

    public function addMapPlace(Request $request, $id = null)
    {

        $postData = json_decode($request->place_data, true);
        $postData = (object)$postData;
        $returnData = $this->addNewPlaceData($postData);

        if ($returnData == false) {
            $response['status'] = 'error';
            $response['msg'] = 'Place or observation already exist!';
            return response()->json($response);
        }
        $postData = (object)array_merge((array)$postData, (array)$returnData);


        //    dd($postData);

        $userId = backpack_auth()->user()->id;
        $response = ['status' => '', 'msg' => '', 'place_detail_id' => '', 'tab' => '', 'completed' => false];

        if (isset($postData->place_detail_id) && $postData->place_detail_id != '') {
            $place_detail = PlaceDetails::find($postData->place_detail_id);
        } else {
            $latitude = $postData->latitude;
            $longitude = $postData->longitude;
            $radius = 100; // Meters
            $place_detail = PlaceDetails::selectRaw("*,
                    ( 6371 * acos( cos( radians(?) )
                    * cos( radians( latitude ) )
                    * cos( radians( longitude ) - radians(?)) + sin( radians(?) )
                    * sin( radians( latitude ) ) )) AS distance", [$latitude, $longitude, $latitude])
                ->having("distance", "<", ($radius / 1000))
                ->where('user_id', $userId)
                ->first();
        }




        if (isset($place_detail)) {

            $place_detail->update([
                'user_id' =>  backpack_auth()->user()->id,
                'place_description' =>  $postData->place_description ? $postData->place_description : NULL,
                'obsevation_description' =>  $postData->observation_description ? $postData->observation_description : NULL,
                // 'latitude' => $postData->latitude,
                // 'longitude' => $postData->longitude,
            ]);

            if (isset($postData->update) && $postData->update == 'place') {
                $place_detail->updatePlaces($place_detail, $postData);
            } else if (isset($postData->update) && $postData->update == 'observation') {
                $place_detail->updateObservations($place_detail, $postData);
            } else {

                dd('here');
                // $place_detail->updateMethod($place_detail,$postData);
            }


            $response['status'] = 'success';
            $response['msg'] = 'data updated successfully!';
        } else {
            $place_detail = PlaceDetails::create([
                'user_id' =>  backpack_auth()->user()->id,
                'place_description' =>  $postData->place_description ? $postData->place_description : NULL,
                'obsevation_description' =>  $postData->observation_description ? $postData->observation_description : NULL,
                'latitude' => $postData->latitude,
                'longitude' => $postData->longitude,
            ]);

            if ($postData->place_id) {
                PlaceDetailPlace::create([
                    'place_detail_id' => $place_detail->id,
                    'place_id' => $postData->place_id,
                    'place_child_id' => $postData->child_place_id ? $postData->child_place_id : NULL,
                ]);
            }

            if (isset($postData->observations) && is_array($postData->observations) && count($postData->observations) > 0) {
                foreach ($postData->observations as $obsrv) {
                    PlaceDetailObservation::create([
                        'place_detail_id' => $place_detail->id,
                        'observation_id' => $obsrv['observation_id'],
                        'observation_child_id' => $obsrv['child_observation_id'] ? $obsrv['child_observation_id'] : NULL,
                        'feeling_id' => $obsrv['feeling_id'],
                    ]);
                }
            }



            backpack_auth()->user()->incrementScore(1);
            $response['status'] = 'success';
            $response['msg'] = 'data added successfully!';
        }

        if ($request->hasFile('place_image')) {
            $request->validate([
                'place_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);
            $imageName = time() . '_place.' . $request->place_image->extension();
            $request->place_image->storeAs('public/uploads/place/', $imageName);

            $place_detail->update([
                'place_image' =>  $imageName,
            ]);
        }

        if ($request->hasFile('observation_image')) {
            $request->validate([
                'observation_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);
            $imageName = time() . '_observation.' . $request->observation_image->extension();
            $request->observation_image->storeAs('public/uploads/observation/', $imageName);
            $place_detail->update([
                'obsevation_image' =>  $imageName,
            ]);
        }



        $response['place_detail_id'] = $place_detail->id;


        if ((isset($place_detail->placeDetail) && $place_detail->placeDetail->id) && (isset($place_detail->observationsDetail) &&  count($place_detail->observationsDetail)) > 0) {
            $response['completed'] = true;
        }

        $response['tab'] = $postData->tab;

        $response['place_id'] = $place_detail->placeDetail->place_id ?? null;

        return response()->json($response);
    }


    public function addNewPlace(Request $request)
    {



        if ($request->place_name) {
            $place = Place::create([
                'name' => $request->place_name,
                'user_id' => backpack_user()->id,
            ]);
        }

        if ($request->observation_name) {
            $observation = Observation::create([
                'name' => $request->observation_name,
                'user_id' => backpack_user()->id,
            ]);
        }


        PlaceDetails::create([
            'place_id' => $request->data->id ?? NULL,
            'latitude' => $request->data->latitude,
            'longitude' => $request->data->longitude,

        ]);

        if ($request->observation_name) {
            return response()->json([
                'status' => 'success',
                'msg' => 'Observation added successfully, You can also add place for this place!',

            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'msg' => 'Place added successfully, You also add obervation for this place!',

            ]);
        }
    }



    public function filter()
    {

        return view('filter');
    }


   
    public function saveComment(Request $request)
    {
        $val = PlaceComment::create(
            [
                'place_id' => $request->id,
                'comment' => $request->comment,
            ]
        );
        return response()->json([
            'status' => 'success'

        ]);
    }

    public function saveGrade(Request $request)
    {
        PlaceGrade::create(
            [
                'place_id' => $request->place_id ,
                'category_id' => $request->category_id,
                'grade' => $request->grade,
            ]
        );
        return response()->json([
            'status' => 'success'

        ]);
    }

    public function savePlace(Request $request)
    {
        $val = Place::create(
            [
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
            ]
        );
        return response()->json([
            'status' => 'success',
            'id' => $val->id

        ]);
    }

    public function saveSubgrade(Request $request)
    {
        PlaceSubgrade::create(
            [
                'place_id' => $request->place_id ?? 0,
                'category_id' => $request->category_id ?? 1,
                'subcategory_id' => $request->subcategory_id ?? 23,
            ]
        );
        return response()->json([
            'status' => 'success'
        ]);
    }

    

    public function truncate()
    {
        // DB::table('place_likes')->delete();
        // DB::table('place_comments')->delete();
        // DB::table('place_detail_places')->delete();
        // DB::table('place_detail_observations')->delete();
        // DB::table('place_details')->delete();

    }
}
