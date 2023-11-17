<?php

namespace App\Models\Master;

use App\Models\MasterLocation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalModel extends Model
{
    protected $table = 'approval_model';
    protected $guarded = [];

    function locationRelation(){
        return $this->hasOne(MasterLocation::class,'id','location_id');
    }
    function approvalRelation(){
        return $this->hasOne(User::class,'id','approval_id');
    }
    function categoryRelation(){
        return $this->hasOne(CategoryModel::class,'id','category_id');
    }
    function userRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }

}
