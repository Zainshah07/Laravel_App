<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('admin.catagory.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'is_active' => 'required|boolean',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'user_id' => auth()->id(),
            'is_active' => $request->is_active,
        ]);

        if ($category) {
            return $this->getLatestRecord('Record Store Successfully', true);
        }
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
