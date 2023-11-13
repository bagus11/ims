<?php

namespace App\Models\Transaction;

use App\Models\Master\ProductModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailItem extends Model
{
    use HasFactory;
    protected $table = 'detail_item';
    protected $guarded = [];

    function itemRelation() {
        return $this->hasOne(ProductModel::class,'product_code','product_code');
    }
}
