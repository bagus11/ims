<?php

namespace App\Models\PettyCash\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentInstructionModel extends Model
{
    use HasFactory;
    protected $table = 'payment_instruction';
    protected $guarded = [];
}
