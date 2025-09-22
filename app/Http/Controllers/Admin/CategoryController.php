<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('admin.catagory.index', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {

        $id=$request->category_id ?? null;

        Category::updateOrCreate(
            ['id'=>$id],
            [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'user_id' => auth()->user()->id,
            'is_active' => $request->is_active,
        ]);


            return $this->getLatestRecord('Record Store Successfully', true);

    }

    //Edit function

    public function edit($id){
        $category = Category::find($id);
        return response()->json([
            'success'=>true,
            'data'=>$category
        ]);

    }

    public function destroy($id){
        $category = Category::find($id);
        $category->delete();
        return $this->getLatestRecord('Record Deleted Successfuly', true);
    }

    private function getLatestRecord($message = 'Record Saved Successfully', $success = true)
    {
        $categories = Category::latest()->get();
        $html = view('admin.catagory.data-table', compact('categories'))->render();

        return response()->json([
            'success' => $success,
            'message' => $message,
            'html' => $html,
        ]);
    }
}
