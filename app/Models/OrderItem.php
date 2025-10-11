<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
  protected $fillable = ['order_id', 'product_id', 'quantity', 'price', 'total'];

    // Relationship: SaleItem belongs to a sale
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relationship: SaleItem belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
