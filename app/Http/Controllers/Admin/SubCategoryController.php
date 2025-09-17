<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function index(){
        $sub_categories=SubCategory::all();
        $categories=Category::all();
        return view('admin.sub-catagory.index',compact('sub_categories','categories'));
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'required|min:3',
            'category_id'=>'required|exists:categories,id',
            'is_active'=>'required|boolean',
        ]);

        $sub_category=SubCategory::create([
            'name'=>$request->name,
            'slug'=>Str::slug($request->name),
            'user_id'=>auth()->id,
            'category_id'=>$request->category_id,
            'is_active'=>$request->is_active
        ]);

        if($sub_category){
            return $this->getLatestRecord('Record Saved Successfuly','true');
        }

    }

    private function getLatestRecord($message='Record Saved Successfuly', $success=true){
        $sub_categories=SubCategory::latest()->get();
        $html=view('admin.sub-catagory.data-table',comapct('sub_categories'))->render();

        return response()->json([
            'success'=> $success,
            'message'=> $message,
            'html'=> $html
        ]);
    }
}
