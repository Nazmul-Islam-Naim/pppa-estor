<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProductDetail extends Model
{
    use HasFactory;
    protected $table = "stock_product_details";
    protected $fillable = [
       'date', 'product_id', 'quantity', 'unit_price', 'reason', 'tok', 'status'
    ];

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');

    }
}
