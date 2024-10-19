<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Config;
use App\Models\Partner;
use App\Models\PartnerProject;
use App\Models\ProjectPerson;
use App\Models\ProjectImage;
use App\Models\ProjectRecognition;
use App\Models\TeamMember;

class ProjectController extends Controller
{
    static function all()
    {
        $projects = Project::all();
        return $projects;
    }
    public function addPartner(Request $request)
    {
        $project = Project::where('name', $request->project);
        if (!$project->exists()) {
            return response()->json([
                'status' => 'Project with this name does not exist',
                'id'=>'',
            ]);            
        }
        $partner = Partner::where('name', $request->partner);
        if (!$project->exists()) {
            return response()->json([
                'status' => 'Partner with this name does not exist',
                'id'=>'',
            ]);            
        }
        $value = new PartnerProject();
        $value->project_id = $project->id;

        $value->partner_id = $partner->id;
        $value->save();
        return response()->json([
            'status' => 'success',
            'id'=>$value->id,
        ]);
    }
    public function addPerson(Request $request)
    {
        $project = Project::where('name', $request->project);
        if (!$project->exists()) {
            return response()->json([
                'status' => 'Project with this name does not exist',
                'id'=>'',
            ]);            
        }
        $person = TeamMember::where('name', $request->person);
        if (!$person->exists()) {
            return response()->json([
                'status' => 'Person with this name does not exist',
                'id'=>'',
            ]);            
        }
        $value = new ProjectPerson();
        $value->project_id = $project->id;
        $value->team_id = $request->team_id;
        
        $value->save();
        return response()->json([
            'status' => 'success',
            'id'=>$value->id,
        ]);
    }
    public function addImage(Request $request)
    {
        $project = Project::where('name', $request->project);
        if (!$project->exists()) {
            return response()->json([
                'status' => 'Project with this name does not exist',
                'id'=>'',
            ]);            
        }
        
        $value = new ProjectImage();
        $value->project_id = $project->id;
        $value->image = $request->image;
        $value->caption = $request->caption ? $request->caption : '';
        
        $value->save();
        return response()->json([
            'status' => 'success',
            'id'=>$value->id,
        ]);
    }
    static function getConfig(string $project_id)
    {
        $projects = Project::where('id', $project_id);
        if (!$projects->exists()) {
            return response()->json([
                'status' => 'Project with this id does not exist',
                'id'=>'',
            ]);            
        }
        
        return Config::where("id", $projects->first()->config_id)->first();
    }
    static function getProject(string $project_id)
    {
        $projects = Project::where('id', $project_id);
        if (!$projects->exists()) {
            return response()->json([
                'status' => 'Project with this id does not exist',
                'id'=>'',
            ]);            
        }
        
        return $projects->first();
    }
    static function getImages(string $project_id)
    {
        $projects = Project::where('id', $project_id);
        if (!$projects->exists()) {
            return response()->json([
                'status' => 'Project with this id does not exist',
                'id'=>'',
            ]);            
        }
        
        $ii = ProjectImage::where('project_id', $project_id);
        if (!$ii->exists()) {
            return response()->json([
                'status' => 'Project with this name does not have images',
                'id'=>'',
            ]);            
        }
        return $ii->get();
    }
    static function getPartners(string $project_id)
    {
        // if (!isset($request->project_id)){
        //     return response()->json([
        //         'status' => 'Project id not set',
        //         'id'=>'',
        //     ]);    
        // }
        $projects = Project::where('id', $project_id);
        if (!$projects->exists()) {
            return response()->json([
                'status' => 'Project with this id does not exist',
                'id'=>'',
            ]);            
        }
        $partners = PartnerProject::where('project_id', $projects->first()->id);
        if (!$partners->exists()) {
            return response()->json([
                'status' => 'This project does not have partners:(',
                'id'=>'',
            ]);            
        }
        $partner_ids = $partners->get()->map(function (PartnerProject $item, int $key) {
            return $item->partner_id;
        });
        return Partner::whereIn('id', $partner_ids)->get();
    }
    static function getTeam(string $project_id)
    {
        // if (!isset($request->project_id)){
        //     return response()->json([
        //         'status' => 'Project id not set',
        //         'id'=>'',
        //     ]);    
        // }
        $projects = Project::where('id', $project_id);
        if (!$projects->exists()) {
            return response()->json([
                'status' => 'Project with this id does not exist',
                'id'=>'',
            ]);            
        }
        $ppl = ProjectPerson::where('project_id', $projects->first()->id);
        if (!$ppl->exists()) {
            return response()->json([
                'status' => 'Project with this id does not have a team',
                'id'=>'',
            ]);            
        }
        $team_ids = $ppl->get()->map(function (ProjectPerson $item, int $key) {
            return $item->team_id;
        });
        
        return TeamMember::whereIn('id', $team_ids)->get();
    }
    static function getRoles(string $project_id)
    {
        // if (!isset($request->project_id)){
        //     return response()->json([
        //         'status' => 'Project id not set',
        //         'id'=>'',
        //     ]);    
        // }
        $projects = Project::where('id', $project_id);
        if (!$projects->exists()) {
            return response()->json([
                'status' => 'Project with this id does not exist',
                'id'=>'',
            ]);            
        }
        $ppl = ProjectPerson::where('project_id', $projects->first()->id);
        if (!$ppl->exists()) {
            return response()->json([
                'status' => 'Project with this id does not have a team',
                'id'=>'',
            ]);            
        }
        return $ppl->get();
    }
    static function getRecognition(string $project_id)
    {
        // if (!isset($request->project_id)){
        //     return response()->json([
        //         'status' => 'Project id not set',
        //         'id'=>'',
        //     ]);    
        // }
        $projects = Project::where('id', $project_id);
        if (!$projects->exists()) {
            return response()->json([
                'status' => 'Project with this id does not exist',
                'id'=>'',
            ]);            
        }
        $award = ProjectRecognition::where('project_id', $projects->first()->id);
        if (!$award->exists()) {
            return response()->json([
                'status'=> 'Project with this id does not have recognitions.'
            ]);            
        }
        return $award->get();
    }
    public function save(Request $request)
    {
        
        $project = new Project();
        $project->name = $request->name;

        $project->description = isset($request->description) ? $request->description : "";
        $project->mappable = isset($request->mappable) ? $request->mappable : 0 ;
        $project->config_id = isset($request->config_id) ? $request->config_id : null;
        $project->start_date = isset($request->start_date) ? $request->start_date : date_create('now')->format('Y-m-d H:i:s');
        $project->end_date = isset($request->end_date) ? $request->end_date : null;
        
        $project->save();
        return response()->json([
            'status' => 'success',
            'id'=>$project->id,
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
