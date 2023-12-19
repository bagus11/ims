<?php

namespace App\Models\PettyCash\Master;

use App\Models\MasterBank;
use App\Models\MasterLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPettyCash extends Model
{
    use HasFactory;
    protected $table = 'master_petty_cash';
    protected $guarded = [];

    function bankRelation(){
        return $this->hasOne(MasterBank::class,'id','bank_id');
    }
    function locationRelation() {
        return $this->hasOne(MasterLocation::class,'id','location_id');
    }


}
