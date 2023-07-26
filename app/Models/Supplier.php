<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = "suppliers";
    protected $fillable = [
    	'supplier_id', 'name', 'email', 'phone', 'address',
        'previous_due','total_due','total_payment','status','created_by'
    ];

    //-------------- user object -----------//
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');

    }
}
