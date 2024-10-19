<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subcategory;

class SubcategoryController extends Controller
{
    static function all()
    {
        $subcategories = Subcategory::all();
        return $subcategories;
    }
    public function save(Request $request)
    {
        $v = Subcategory::create(
            [
                'name' => $request->name,
            ]
        );
        return response()->json([
            'status' => 'success',
            'id'=>$v->id
        ]);
    }
}
