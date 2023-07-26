<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory;
    protected $table = 'product_units';
    protected $fillable = [
    	'name', 'status','created_by'
    ];

    //--------- user object -------------//
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');

    }
}
