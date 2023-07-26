<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousStockProduct extends Model
{
    use HasFactory;
    protected $table = "previous_stock_products";
    protected $fillable = [
    	'product_id', 'unit_price', 'quantity', 'stock_date', 'tok', 'created_by'
    ];
    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
    
    public function user()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}
