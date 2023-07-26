<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
    	'name', 'product_type_id','product_category_id','product_sub_category_id','product_unit_id',
        'product_brand_id','stock_notify','note', 'status','created_by'
    ];

    //--------- product type object -------------//
    public function type()
    {
        return $this->hasOne('App\Models\ProductType', 'id', 'product_type_id');

    }
    //--------- product category object -------------//
    public function category()
    {
        return $this->hasOne('App\Models\ProductCategory', 'id', 'product_category_id');

    }
    //--------- product sub category object -------------//
    public function subcategory()
    {
        return $this->hasOne('App\Models\ProductSubCategory', 'id', 'product_sub_category_id');

    }
    //--------- product unit object -------------//
    public function unit()
    {
        return $this->hasOne('App\Models\ProductUnit', 'id', 'product_unit_id');

    }
    //--------- product brand object -------------//
    public function brand()
    {
        return $this->hasOne('App\Models\ProductBrand', 'id', 'product_brand_id');

    }
    //--------- user object -------------//
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');

    }

    public function stockProduct(){
        return $this->hasOne(StockProduct::class);
    }

}
