<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\PartnerProject;

class PartnerController extends Controller
{
    static function all()
    {
        $entries = Partner::all();
        return $entries;
    }
    public function save(Request $request)
    {
        if (!isset($request->name)){
            return response()->json([
                'status' => 'missing partner name',
                'id'=>'',
            ]);
        }
        $entry = Partner::where('name', $request->name);
        $check = $entry->exists();
        if (!$check) {
            $entry = new Partner();
        }
        $entry->name = $request->name;
        $entry->link = isset($request->link) ?? $request->link;
        $entry->image = isset($request->image) ?? $request->image;
        $entry->save();
        if (isset($request->project_id)){
            $v = new PartnerProject();
            $v->partner_id = $entry->id;
            $v->project_id = $request->project_id;
            $v->save();
        }
        
        return response()->json([
            'status' => 'success',
            'id'=>$entry->id,
        ]);
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
