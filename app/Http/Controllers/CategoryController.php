<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    static function all()
    {
        $categories = Category::all();
        return $categories;
    }

    public function save(Request $request)
    {
        $v = Category::create(
            [
                'name' => $request->name,
                'description' => $request->description,
            ]
        );
        return response()->json([
            'status' => 'success',
            'grade'=>$v->id
        ]);
    }
}
