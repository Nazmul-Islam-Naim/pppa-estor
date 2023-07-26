<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DamageRequestProduct extends Model
{
    use HasFactory;

    protected $fillable = ['damage_request_id', 'product_id','quantity', 'adjusted'];



    //relationships

    public function damageRequest(){
        return $this->belongsTo(DamageRequest::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }


    //scope

    public static function scopeCheckDate($query){
        if(request()->start_date){
            $query->where('adjusted','>=',date('Y-m-d',strtotime(request()->start_date)));
        }

        if(request()->end_date){
            $query->where('adjusted','<=',date('Y-m-d',strtotime(request()->end_date)));
        }

        if(! request()->start_date && !request()->end_date){
            $query->where('adjusted','=',date('y-m-d'));
        }
    }

    //method

    public static function getProductsQuery($user_id = null, $product_id,$start_date= null , $end_date=null){
        $user_id= $user_id??Auth::user()->id;
        $query = self::whereHas('damageRequest',function($query) use($user_id){
            $query->where('user_id', $user_id)->where('status',1);
        })->where('product_id',$product_id);

        if($start_date){
            $query->where('adjusted','>=',$start_date);
        }

        if($end_date){
            $query->where('adjusted','<=',$end_date);
        }

        return $query;
    }
}
