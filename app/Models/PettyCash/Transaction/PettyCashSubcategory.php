<?php

namespace App\Models\PettyCash\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCashSubcategory extends Model
{
    use HasFactory;
    protected $table = 'pettycash_subcategory_request';
    protected $guarded = [];
}
