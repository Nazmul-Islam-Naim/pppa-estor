<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'department_id',
        'designation_id',
        'image',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //method

    public function hasPermission($permission): bool
    {
        return $this->role->permissions()->where('slug', $permission)->first() ? true : false;
    }


    //Relationships


    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function designation(){
        return $this->belongsTo(Designation::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function requisitions(){
        return $this->hasMany(Requisition::class);
    }

    public function requisitionComments(){
        return $this->hasMany(RequisitionComment::class);
    }

    //method

    public function isStoreKeeper(){
        return $this->role->slug  == 'store-keeper';
        
    }


    
}
