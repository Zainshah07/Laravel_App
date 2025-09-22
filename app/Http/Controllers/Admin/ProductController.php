<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\FileUploadManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index(){
        $products = Product::with('category','sub_category')->latest('created_at')->get();
        return view('admin.product.index',compact('products'));
    }

    public function store(ProductRequest $request){

        $id= $request->product_id ?? null;

      $product = Product::updateOrCreate(
            ['id'=> $id],
            [
                'name'=>$request->name,
                'sku'=>strtoupper(Str::random(4)),
                'quantity'=>$request->quantity,
                'category_id'=>$request->category_id,
                'sub_category_id' => $request->sub_category_id ?: null,
                'unit_price'=>$request->unit_price,
                'cost_price_per_unit'=>$request->cost_price_per_unit,
                'is_active'=>$request->is_active,

            ]

        );

        if($request->hasFile('images')){
            $image = FileUploadManager::uploadFile($request->images,'Images/');
            $product->images = json_encode([$image['path']]);
            $product->save();
        }




         return $this->getLatestRecord('Record Saved Successfuly', true);


    }

    public function edit($id){
        $product=Product::find($id);
        return response()->json([
            'success'=> true,
            'data'=> $product
        ]);
    }

       public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return $this->getLatestRecord('Record Deleted Successfuly', true);
    }

     private function getLatestRecord($message='Record Saved Successfuly', $success=true){

        $products = Product::with('category','sub_category')->latest('created_at')->get();
        $html = view('admin.product.data-table',compact('products'))->render();
        return response()->json([
            'success'=> $success,
            'message'=> $message,
            'html'=> $html
        ]);
    }
}
