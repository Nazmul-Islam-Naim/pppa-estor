<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $table = "assets";
    protected $fillable = [
    	'name','asset_type_id','asset_sub_type_id','quantity','writter','image', 'status','created_by'
    ];


    //----------------- type ------------------//
    public function assettype()
    {
        return $this->hasOne('App\Models\AssetType','id','asset_type_id');
    }

    //----------------- sub type ------------------//
    public function assetsubtype()
    {
        return $this->hasOne('App\Models\AssetSubType','id','asset_sub_type_id');
    }

    //----------------- user ------------------//
    public function user()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }
}
