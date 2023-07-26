<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageRequestComment extends Model
{
    use HasFactory;
    
    protected $fillable = ['damage_request_id','comment','type','user_id','status'];


    //Relationships

    public function damangeRequest(){
        return $this->belongsTo(DamageRequest::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
