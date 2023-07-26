<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    use HasFactory;
    protected $table = "asset_types";
    protected $fillable = [
    	'name', 'status','created_by'
    ];


    //----------------- user ------------------//
    public function user()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }
}
