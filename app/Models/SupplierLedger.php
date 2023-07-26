<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierLedger extends Model
{
    use HasFactory;
    protected $table = "supplier_ledgers";
    protected $fillable = [
     	'date', 'supplier_id', 'bank_id', 'amount', 'reason', 'tok', 'status', 'created_by'
    ];

    //------------------------ supplier object -------------//
    public function supplier()
    {
        return $this->hasOne('App\Models\Supplier', 'id', 'supplier_id');

    }

    //------------------------ bank object -------------//
    public function bank()
    {
        return $this->hasOne('App\Models\BankAccount', 'id', 'bank_id');

    }
    
    //------------------------ user object -------------//
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'created_by');

    }

}
