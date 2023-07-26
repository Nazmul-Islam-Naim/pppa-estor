<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    use HasFactory;
    protected $table = 'product_sub_categories';
    protected $fillable = [
    	'name','product_category_id', 'status','created_by'
    ];

    //--------- product category object -------------//
    public function category()
    {
        return $this->hasOne('App\Models\ProductCategory', 'id', 'product_category_id');

    }
    //--------- user object -------------//
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');

    }
}
