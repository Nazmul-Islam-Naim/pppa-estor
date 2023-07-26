<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    use HasFactory;
    protected $table = "product_purchases";
    protected $fillable = [
    	'supplier_id', 'tender_number','amount', 'tok', 'purchase_date', 'status', 'created_by'
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

    //----------------- user object ----------------//
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');

    }
}
