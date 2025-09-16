<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes; // <--- Enable Soft Deletes

    protected $fillable = [
        'name',
        'slug',
        'user_id',
        'is_active',
    ];
}
