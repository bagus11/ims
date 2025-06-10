<?php

namespace App\Models\Transaction;

use App\Models\Master\ApprovalModel;
use App\Models\Master\CategoryModel;
use App\Models\Master\ProductModel;
use App\Models\MasterLocation;
use App\Models\PettyCash\Master\MasterCategoryPC;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRequestModel extends Model
{
    use HasFactory;
    protected $table = 'item_request_model';
    protected $guarded = [];

    function locationRelation(){
        return $this->hasOne(MasterLocation::class,'id','location_id');
    }
    function desLocationRelation(){
        return $this->hasOne(MasterLocation::class,'id','des_location_id');
    }

    function itemRelation() {
        return $this->hasOne(ProductModel::class,'product_code','item_id');
    }

    function userRelation() {
        return $this->hasOne(User::class,'id','user_id');
    }
    function approvalRelation() {
        return $this->hasOne(User::class,'id','approval_id');
    }
    function stepRelation() {
        return $this->hasOne(ApprovalModel::class,'category_id','category_id');
    }
    function categoryRelation() {
        return $this->hasOne(CategoryModel::class,'id','category_id');
    }
    function purchaseRelation() {
        return $this->hasMany(PurchaseModel::class,'request_code','request_code');
    }
}
