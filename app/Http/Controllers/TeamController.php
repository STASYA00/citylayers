<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamMember;
use App\Models\ProjectPerson;

class TeamController extends Controller
{
    static function all()
    {
        $entries = TeamMember::all();
        return $entries;
    }
    static function teamProjects()
    {
        $entries = ProjectPerson::all();
        return $entries;
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
