<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectImage;

class ProjectImageController extends Controller
{
    static function all()
    {
        $ims = ProjectImage::all();
        return $ims;
    }
   


    // public function update_config($request)
    // {
    //     $project = Project::where('id', $request->id)->first();
    //     $project->config_id = $request->config_id;
    //     return response()->json([
    //         'status' => 'success',
    //         'id'=>$project->id
    //     ]);
    // }
}
