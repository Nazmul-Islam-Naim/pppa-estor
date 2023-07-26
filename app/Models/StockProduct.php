<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProduct extends Model
{
    use HasFactory;
    protected $table = "stock_products";
    protected $fillable = [
    	'product_id', 'quantity', 'unit_price', 'status','created_by'
    ];

    //------------------ product object ------------//
    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');


    }
    //------------------ user object ------------//
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');

    }
}
