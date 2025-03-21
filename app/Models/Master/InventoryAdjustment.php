<?php

namespace App\Models\Master;

use App\Models\MasterLocation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryAdjustment extends Model
{
    use HasFactory;
    protected $guarded = [];

    function userRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
    function categoryRelation() {
        return $this->hasOne(CategoryModel::class,'id','category_id');
    }
    function locationRelation() {
        return $this->hasOne(MasterLocation::class,'id','location_id');
    }
}
