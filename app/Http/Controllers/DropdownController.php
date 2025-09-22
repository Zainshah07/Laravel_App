<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class DropdownController extends Controller
{
    public function getCategories(Request $request)
    {
        $categories = Category::where('is_active', Category::ACTIVE_STATUS)->orderBy('name', 'asc')->get(['id', 'name']);

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }


    public function getSubCategories(Request $request){
    $subCategories = SubCategory::where('category_id', $request->category_id)
        ->where('is_active', SubCategory::ACTIVE_STATUS)
        ->orderBy('name', 'asc')
        ->get(['id', 'name']);

    return response()->json(['success' => true, 'data' => $subCategories]);
}

}
