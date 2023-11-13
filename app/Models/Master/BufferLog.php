<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BufferLog extends Model
{
    use HasFactory;
    protected $table = 'buffer_log';
    protected $guarded = [];

    function productRelation() {
        return $this->hasOne(ProductModel::class, 'product_code', 'product_code');
    }
    function userRelation() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
