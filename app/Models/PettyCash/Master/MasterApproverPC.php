<?php

namespace App\Models\PettyCash\Master;

use App\Models\MasterDepartment;
use App\Models\MasterLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterApproverPC extends Model
{
    use HasFactory;
    protected $table = 'master_approver_pc';
    protected $guarded = [];

    function locationRelation(){
        return $this->hasOne(MasterLocation::class,'id','location_id');
    }
    function departmentRelation(){
        return $this->hasOne(MasterDepartment::class,'id','department_id');
    }
}
