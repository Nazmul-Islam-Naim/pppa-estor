<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPurchaseDetail extends Model
{
    use HasFactory;
    protected $table = "product_purchase_details";
    protected $fillable = [
    	'supplier_id', 'product_id', 'unit_price', 'quantity', 'tok', 'purchase_date', 'status', 'created_by'
    ];

    //----------------- supplier object ----------------//
    public function supplier()
    {
        return $this->hasOne('App\Models\Supplier', 'id', 'supplier_id');

    }
    
    //----------------- product object ----------------//
    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');

    }

    //----------------- tender object ----------------//
    public function tender()
    {
        return $this->hasOne('App\Models\ProductPurchase', 'tok', 'tok');

    }

    //----------------- stock object ----------------//
    public function stock()
    {
        return $this->hasOne('App\Models\StockProduct', 'id', 'product_id');

    }

    //----------------- user object ----------------//
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');

    }
}
