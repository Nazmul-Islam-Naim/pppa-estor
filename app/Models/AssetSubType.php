<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetSubType extends Model
{
    use HasFactory;
    protected $table = "asset_sub_types";
    protected $fillable = [
    	'name','asset_type_id', 'status','created_by'
    ];


    //----------------- type ------------------//
    public function assetType()
    {
        return $this->hasOne('App\Models\AssetType','id','asset_type_id');
    }

    //----------------- user ------------------//
    public function user()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }
}
