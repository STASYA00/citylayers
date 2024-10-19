<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspect;
use App\Models\AspectRelation;
use App\Models\ConfigCategory;
use App\Models\Config;
use App\Models\ConfigSubcategory;
use App\Models\Level;
use App\Models\Question;
use App\Models\QuestionLocation;

class ConfigController extends Controller
{
    static function all()
    {
        $configs = Config::all();
        return $configs;
    }
    
    function categories($postData)
    {
        $categories = ConfigCategory::where('config_id', $postData->config)->get()->category_id;
        return $categories;
    }
    static function allcategories()
    {
        $categories = ConfigCategory::all();
        return $categories;
    }

    static function getQuestions(string $config_id)
    {
        $configquestions = QuestionLocation::where('config_id', $config_id);
        if (!$configquestions->exists()) {
            return response()->json([
                'status' => 'Project with this id does not exist',
                'id'=>'',
            ]);            
        }
        
        $configquestions_ids = $configquestions->get()->map(function (QuestionLocation $item, int $key) {
            return $item->question_id;
        });
        return Question::whereIn('id', $configquestions_ids)->get();
    }

    static function getAspects(string $config_id)
    {
        $configquestions = QuestionLocation::where('config_id', $config_id);
        if (!$configquestions->exists()) {
            return response()->json([
                'status' => 'Config with this id does not have aspects',
                'id'=>'',
            ]);            
        }
        
        $aspect_ids = $configquestions->get()->map(function (QuestionLocation $item, int $key) {
            return $item->aspect_id;
        });
        return Aspect::whereIn('id', $aspect_ids)->get();
    }

    static function getHierarchy(string $config_id)
    {
        return AspectRelation::where('config_id', $config_id)->get();
    }

    static function getLevels(string $config_id)
    {
        return Level::where('config_id', $config_id)->get();
    }

    static function getQuestionLocs(string $config_id)
    {
        return QuestionLocation::where('config_id', $config_id)->get();
        
        
    }

    function subcategories($postData)
    {
        $subcategories = ConfigSubcategory::where('config_id', $postData->config)->get()->subcategory_id;
        return $subcategories;
    }

    public function save(Request $request)
    {
        $config = new Config();
        $config->name = $request->name;
        $config->description = $request->description;
        $config->save();
        return response()->json([
            'status' => 'success',
            'id'=>$config->id,
        ]);
    }

    public function assign(Request $request)
    {
        $check = ConfigCategory::where('config_id', $request->config_id)->where('category_id', $request->category_id)->exists();
            if ($check) {
                return false;
            }
        $config = new ConfigCategory();  
        $config->config_id = $request->config_id;
        $config->category_id = $request->category_id;
        $config->color = $request->color ? $request->color : "FFFFFF";
        $config->high = $request->high ? $request->high : "High";
        $config->low = $request->low ? $request->low : "Low";
        $config->save();
        return response()->json([
            'status' => 'success',
            'id'=>$config->id,
        ]);
    }

    public function assign_categories(Request $request)
    {
        $check = ConfigCategory::where('config_id', $request->config_id)->where('category_id', $request->category_id)->exists();
            if ($check) {
                return false;
            }
        $config = new ConfigCategory();
        // check that config_id exists
        // check that category_id exists    
        $config->config_id = $request->config_id;
        $config->category_id = $request->category_id;
        $config->color = $request->color ? $request->color : "FFFFFF";
        $config->high = $request->high ? $request->high : "High";
        $config->low = $request->low ? $request->low : "Low";
        $config->save();
        return response()->json([
            'status' => 'success',
            'id'=>$config->id,
        ]);
    }

    public function assign_subcategories(Request $request)
    {
        $check = ConfigCategory::where('config_id', $request->config_id)->where->exists();

            if ($check) {

                return false;
            }
        $config = new ConfigSubcategory();
        // check that config_id exists
        // check that category_id exists    
        $config->config_id = $request->config_id;
        $config->category_id = $request->category_id;
        $config->color = $request->color ? $request->color : "FFFFFF";
        $config->high = $request->high ? $request->high : "High";
        $config->low = $request->low ? $request->low : "Low";
        $config->save();
        return response()->json([
            'status' => 'success',
            'id'=>$config->id,
        ]);
    }
}
