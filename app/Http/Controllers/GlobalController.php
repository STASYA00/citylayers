<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Place;
use App\Models\PlaceComment;
use App\Models\PlaceGrade;
use App\Models\PlaceImage;
use App\Models\PlaceSubgrade;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Question;
use App\Models\Page;

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

    static function grades()
    {
        $grades = PlaceGrade::all();
        return $grades;
    }

    static function subgrades()
    {
        $subgrades = PlaceSubgrade::all();
        return $subgrades;
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

    static function pages()
    {
        $pages = Page::all();
        return $pages;
    }

    


    //----------------------new code----------------------






    public function filter()
    {

        return view('filter');
    }


   
    public function saveComment(Request $request)
    {
        PlaceComment::create(
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
        $valp = PlaceGrade::create(
            [
                'place_id' => $request->place_id ,
                'category_id' => $request->category_id,
                'grade' => $request->grade,
            ]
        );

        $postData = json_decode($request, true);
//        $postData['grade_id'] = $valp->id;
        $postData = (object)$postData;
        $this->saveSubgrades($request, $valp->id);
        return response()->json([
            'status' => 'success',
            'id' => $valp->id
        ]);
    }

    public function saveImage(Request $request)
    {
        // $imageName = 'korv.png';
        // $request->image->storeAs('public/uploads/place/', $imageName);
        
        // if ($request->hasFile('image')) {
        //     $request->validate([
        //         'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        //     ]);

        //     $imageName = $request->image_name . $request->image->extension();
            
        //     $request->image->storeAs('public/uploads/place/', $imageName);
            
        // }

        PlaceImage::create(
            [
                'place_id' => $request->id,
                'image' => $request->image_name,
            ]
        );
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);
            $request->image->storeAs('public/uploads/', $request->image_name);

        }
        // $request->image->storeAs('public/uploads/', $request->image_name ?? 'korv.png');
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

    public function saveObs(Request $request)
    {
        $val = Place::create(
            [
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
            ]
        );
        if (isset($request->comment) && $request->comment != ''){
            PlaceComment::create(
                [
                    'place_id' => $val->id,
                    'comment' => $request->comment,
                ]
            );
        }
        if (isset($request->image_name) && $request->image_name != ''){
            
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif',
                ]);
                PlaceImage::create(
                    [
                        'place_id' => $val->id,
                        'image' => $request->image_name,
                    ]
                );
                $request->image->storeAs('public/uploads/', $request->image_name);
    
            }
        }

        if (isset($postData->observations)){
            $postData = json_decode($request->observations, true);
            if (is_array($postData) &&
                    count($postData) > 0) {
                foreach ($postData as $obsrv) {
                    $ob = (object)$obsrv;
                    $grade = PlaceGrade::create(
                        [
                            'place_id' => $val->id ,
                            'category_id' => $ob->category_id,
                            'grade' => $ob->grade,
                        ]
                    );
                    if (isset($ob->subgrades) && is_array($ob->subgrades) &&
                        count($ob->subgrades) > 0) {

                            foreach ($ob->subgrades as $subgrade) {

                                PlaceSubgrade::create(
                                    [
                                        'grade_id' => $grade->id,
                                        'category_id' => $ob->category_id,
                                        'subcategory_id' => $subgrade,
                                    ]
                                );
                            }
                        }
                    }
                }
        }
        

        
        return response()->json([
            'status' => 'success',
            'id' => $val->id

        ]);
    }   
    

    public function saveSubgrade(Request $request)
    {
        $v = PlaceSubgrade::create(
            [
                'grade_id' => $request->grade_id,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
            ]
        );
        return response()->json([
            'status' => 'success',
            'grade'=>$v->grade_id
        ]);
    }

    public function saveSubgrades(Request $request, $grade_id)
    {
        parse_str($request->obs, $obs);
        foreach ($obs as $x=>$ob) {                                                                                                                       PlaceSubgrade::create(
                [
                    'grade_id' => $grade_id,
                    'category_id' => $request->category_id,
                    'subcategory_id' => $ob,
                ]
            );
        }

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
