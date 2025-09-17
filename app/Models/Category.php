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

    public function sub_category()
    {
        return $this->hasMany(SubCategory::class);
    }
}
