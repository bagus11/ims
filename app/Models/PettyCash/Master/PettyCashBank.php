<?php

namespace App\Models\PettyCash\Master;

use App\Models\MasterLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCashBank extends Model
{
    use HasFactory;
    protected $table = 'petty_cash_bank';
    protected $guarded = [];

    function locationRelation() {
        return $this->hasOne(MasterLocation::class,'id','location_id');
    }
}
