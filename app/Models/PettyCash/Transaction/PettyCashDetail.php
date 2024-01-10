<?php

namespace App\Models\PettyCash\Transaction;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCashDetail extends Model
{
    use HasFactory;
    protected $table = 'petty_cash_detail';
    protected $guarded = [];
    function picRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
    function creatorRelation() {
        return $this->hasOne(User::class,'id','creator');
    }
}
