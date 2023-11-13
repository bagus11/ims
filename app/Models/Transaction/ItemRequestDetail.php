<?php

namespace App\Models\Transaction;

use App\Models\Master\ProductModel;
use App\Models\MasterLocation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRequestDetail extends Model
{
    use HasFactory;
    protected $table = 'item_request_detail';
    protected $guarded = [];

    function locationRelation(){
        return $this->hasOne(MasterLocation::class,'id','location_id');
    }

    function itemRelation() {
        return $this->hasOne(ProductModel::class,'product_code','item_id');
    }

    function userRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
    function creatorRelation() {
        return $this->hasOne(User::class,'id','creator');
    }
}
