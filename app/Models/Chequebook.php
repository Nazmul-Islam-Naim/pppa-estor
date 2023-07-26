<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chequebook extends Model
{
    use HasFactory;

    protected $table = "cheque_books";
    protected $fillable = [
    	'name', 'bank', 'status'
    ];

    public function chequebook_bank_object()
    {
        return $this->hasOne('App\Models\BankAccount', 'id', 'bank');
    }
}
