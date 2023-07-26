<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth ;

class DesignationWiseProductDetail extends Model
{
    use HasFactory;
    protected $table = "designation_wise_product_details";
    protected $fillable = [
    	'designation_id','product_id','product_type_id','quantity','tok','date','status','created_by'
    ];

    //-------------- designation object -----------//
    public function designation()
    {
        return $this->hasOne('App\Models\Designation', 'id', 'designation_id');

    }
    //-------------- product object -----------//
    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');

    }
    //-------------- user object -----------//
    public function creator()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');

    }
    //-------------- user wise asset object -----------//
    public function userAsset()
    {
        return $this->hasOne('App\Models\DesignationWiseAssetDetail', 'user_id', Auth::id());

    }


    //scopes

    // public static function scopeAvailable($query, $user){
    //     $requsitionProducts = RequisitonProduct::getProductsQuery($user->id,Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth())->get();
    //     $quantity = 0;
    //     if(count($requsitionProducts)){
    //         $quantity = $requsitionProducts->sum('quantity');
    //     }
    //     $query->where('')
    // }
}
