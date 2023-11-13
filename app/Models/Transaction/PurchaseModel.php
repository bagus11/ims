<?php

namespace App\Models\Transaction;

use App\Models\Master\ProductModel;
use App\Models\MasterLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseModel extends Model
{
    use HasFactory;
    protected $table = 'purchase_model';
    protected $guarded = [];
    function itemRelation() {
        return $this->hasOne(ProductModel::class,'product_code','product_code');
    }
    function transactionRelation() {
        return $this->hasOne(ItemRequestModel::class,'request_code','request_code');   
    }
}
