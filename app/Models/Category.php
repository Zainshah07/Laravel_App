<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'user_id',
        'is_active',
    ];

    const ACTIVE_STATUS = 1;

    const INACTIVE_STATUS = 0;

    public function subCategory()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }



    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            if ($category->isForceDeleting()) {
                // If force deleting, delete subcategories from DB
                $category->sub_category()->forceDelete();
            } else {
                // If soft deleting, soft delete subcategories too
                $category->sub_category()->delete();
            }
        });
    }
}
