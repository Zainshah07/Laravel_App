<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model

{

    protected $fillable = [
        'name',
        'sku',
        'quantity',
        'category_id',
        'sub_category_id',
        'images',
        'unit_price',
        'cost_price_per_unit',
        'is_active',
    ];
       const ACTIVE_STATUS = 1;

        const INACTIVE_STATUS = 0;

      public function getImagesAttribute($value){
      if (!$value) {
        return asset('default-profile.png'); // fallback image
    }

    $decoded = json_decode($value, true);
    $path = is_array($decoded) ? $decoded[0] : $decoded;

    return asset('storage/' . ltrim($path, '/'));
    }



     public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
