<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function index(){
        $sub_categories=SubCategory::all();
        return view('admin.sub-catagory.index',compact('sub_categories'));
    }
}
