<?php

namespace App\Models;

use App\Enum\Status;
use App\Exceptions\QuantityException;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Requisition extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'status', 'note', 'username', 'user_id'];


    //Relationships
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function requisitionProducts(){
        return $this->hasMany(RequisitonProduct::class);
    }

    public function requisitionComments(){
        return $this->hasMany(RequisitionComment::class);
    }

    //Method

    public function isOwner(){
        return $this->user->id == Auth::user()->id;
    }

    public function can($status, $user){
        $owner = ['Pending','Published',"Confirmed"];
        $approver=['Pending','Approver'];
        $storekeeper=['Pending','Storekeeper'];

        if($this->isOwner()){
            return in_array($status->toString(), $owner);
        }


        if($user->isStoreKeeper()){
            if( $status->toString() == 'Pending' ){
                return true;
            }
            
            foreach($this->requisitionProducts as $requisitionproduct){
                if(!$requisitionproduct->product->stockProduct){
                    throw new QuantityException($requisitionproduct->product->name.' doesnt have enough stock');
                }
                if($requisitionproduct->product->stockProduct->quantity < $requisitionproduct->quantity){
                    throw new QuantityException($requisitionproduct->product->name.' doesnt have enough stock');
                }
            }
            return in_array($status->toString(), $storekeeper) ;
        }

        if($user->hasPermission('app.requisition.approve')){
            return in_array($status->toString(), $approver);
        }
    }

    //Scopes 

    public function scopeAuthorized($query){
        $query->whereHas('user',function($query){
            $query->where('id',Auth::user()->id);
        });
        
        if(Auth::user()->hasPermission('app.requisition.approve') && !  Auth::user()->isStoreKeeper()){
            $query->orWhere('status', Status::getFromName('Published'));
        }

        if(Auth::user()->hasPermission('app.requisition.approve') && Auth::user()->isStoreKeeper()){
            $query->orWhere('status', Status::getFromName('Approver'));
        }
    }


    public static function scopeCheckUser($query, $user){
        $query->whereHas('user', function($query) use($user){
            $query->where('id', $user->id);
        });
    }

    public static function scopeConfirmed($query){
        $query->where('status', Status::Confirmed->value);
    }

    public static function scopePending($query){
        if(request()->status == "Published" || request()->status == "Approver"){
            $query->where('status', Status::getFromName(request()->status)->value);
        }
    }

    public function scopeCheckStatus($query, $status = null){
        $status = $status??request()->status;

        if($status){
            $query->where('status', Status::getFromName($status)->value);
        }
    }
    
}

