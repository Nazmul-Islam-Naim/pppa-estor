<?php

namespace App\Models;

use App\Enum\Status;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DamageRequest extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'status', 'note', 'username', 'user_id'];


    //Relationships
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function damageRequestProducts(){
        return $this->hasMany(DamageRequestProduct::class);
    }
    
    public function damageRequestComments(){
        return $this->hasMany(DamageRequestComment::class);
    }

    //Method

    public function isOwner(){
        return $this->user->id == Auth::user()->id;
    }

    public function can($status, $user){
        $owner = ['Pending','Published'];
        $approver=['Pending','Approver'];

        if($this->isOwner()){
            return in_array($status->toString(), $owner);
        }

        if($user->hasPermission('app.damage.request.approve')){
            return in_array($status->toString(), $approver);
        }
    }

    //Scopes 

    public function scopeAuthorized($query){

        $query->whereHas('user',function($query){
            $query->where('id',Auth::user()->id);
        });

        if(Auth::user()->hasPermission('app.damage.request.approve') ){
            $query->orWhere('status', Status::getFromName('Published'));
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
