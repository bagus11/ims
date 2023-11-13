<?php

namespace App\Models\Master;

use App\Models\MasterLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterApprover extends Model
{
    use HasFactory;
    protected $table = 'master_approver';
    protected $guarded = [];
    function locationRelation(){
        return $this->hasOne(MasterLocation::class,'id','location_id');
    }
    function categoryRelation(){
        return $this->hasOne(CategoryModel::class,'id','category_id');
    }
}
