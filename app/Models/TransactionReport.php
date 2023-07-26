<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionReport extends Model
{
    use HasFactory;

    protected $table = "transaction_reports";
    protected $fillable = [
    	'bank_id', 'transaction_date', 'amount', 'keyword', 'reason', 'note', 'tok', 'status', 'created_by'
    ];

    public function transactionreport_bank_object()
    {
        return $this->hasOne('App\Models\BankAccount', 'id', 'bank_id');
    }
}
