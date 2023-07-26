<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignationWiseProduct extends Model
{
    use HasFactory;
    protected $table = "designation_wise_products";
    protected $fillable = [
    	'designation_id','tok','date','note','status','created_by'
    ];

    //-------------- designation object -----------//
    public function designation()
    {
        return $this->hasOne('App\Models\Designation', 'id', 'designation_id');

    }
    //-------------- user object -----------//
    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');

    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
