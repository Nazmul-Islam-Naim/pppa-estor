<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignationWiseAssetDetail extends Model
{
    use HasFactory;
    protected $table = "designation_wise_asset_details";
    protected $fillable = [
    	'designation_id','asset_id','quantity','max_limit','des','tok','date','status','created_by'
    ];

    //-------------- user object -----------//
    public function designation()
    {
        return $this->hasOne('App\Models\Designation', 'id', 'designation_id');

    }
    //-------------- product object -----------//
    public function asset()
    {
        return $this->hasOne('App\Models\Product', 'id', 'asset_id');

    }
    //-------------- user object -----------//
    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');

    }

     //scope

    public static function scopeCheckUser($query, $user = null){
        $user = $user?? Auth::user();
        $query->where('designation_id', $user->designation->id);
    }

    public static function scopeCheckAsset($query, $asset_id){
        $query->where('asset_id', $asset_id);
    }
}
