<?php

namespace App\Models\Transaction;

use App\Models\Master\ProductModel;
use App\Models\MasterLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryProduct_model extends Model
{
    use HasFactory;
    
    protected $table = 'history_product_model';
    protected $guarded = [];

    function locationRelation(){
        return $this->hasOne(MasterLocation::class,'id','source_location');
    }
    function desLocationRelation(){
        return $this->hasOne(MasterLocation::class,'id','destination_location');
    }

    function itemRelation() {
        return $this->hasOne(ProductModel::class,'product_code','product_code');
    }
    function transactionRelation() {
        return $this->hasOne(ItemRequestModel::class,'request_code','request_code');   
    }
}
