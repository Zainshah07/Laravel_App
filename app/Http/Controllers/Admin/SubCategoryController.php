<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index(){
        $sub_categories = SubCategory::with('category','user')->latest('created_at')->get();
        return view('admin.sub-catagory.index',compact('sub_categories'));
    }

    public function store(SubCategoryRequest $request)
    {
        $id = $request->sub_category_id ?? null;
        SubCategory::updateOrCreate(
            ['id' => $id],
            [
                'name'=>$request->name,
                'slug'=>Str::slug($request->name),
                'user_id'=> auth()->user()->id,
                'category_id'=>$request->category_id,
                'is_active'=>$request->is_active
            ]);
        return $this->getLatestRecord('Record Saved Successfuly', true);
    }

    public function edit($id)
    {
        $sub_category = SubCategory::find($id);
        return response()->json([
            'success'=> true,
            'data'=> $sub_category
        ]);
    }

    public function destroy($id)
    {
        $sub_category = SubCategory::find($id);
        $sub_category->delete();
        return $this->getLatestRecord('Record Deleted Successfuly', true);
    }

    private function getLatestRecord($message='Record Saved Successfuly', $success=true){
        $sub_categories = SubCategory::with('category','user')->latest('created_at')->get();
        $html = view('admin.sub-catagory.data-table',compact('sub_categories'))->render();
        return response()->json([
            'success'=> $success,
            'message'=> $message,
            'html'=> $html
        ]);
    }
}
