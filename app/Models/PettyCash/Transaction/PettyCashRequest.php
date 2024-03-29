<?php

namespace App\Models\PettyCash\Transaction;

use App\Models\MasterDepartment;
use App\Models\MasterLocation;
use App\Models\PettyCash\Master\MasterCategoryPC;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCashRequest extends Model
{
    use HasFactory;
    protected $table = 'petty_cash_request';
    protected $guarded = [];

    function categoryRelation() {
        return $this->hasOne(MasterCategoryPC::class,'id','category_id');
    }
    function locationRelation() {
        return $this->hasOne(MasterLocation::class,'id','location_id');
    }
    function requesterRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
    function picRelation() {
        return $this->hasOne(User::class,'id','pic_id');
    }
    function approvalRelation() {
        return $this->hasOne(User::class,'id','approval_id');
    }
    function departmentRelation() {
        return $this->hasOne(MasterDepartment::class,'id','department');
    }
}
