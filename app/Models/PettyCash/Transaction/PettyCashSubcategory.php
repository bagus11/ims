<?php

namespace App\Models\PettyCash\Transaction;

use App\Models\Master\CategoryModel;
use App\Models\PettyCash\Master\MasterCategoryPC;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCashSubcategory extends Model
{
    use HasFactory;
    protected $table = 'pettycash_subcategory_request';
    protected $guarded = [];

    function categoryRelation() {
        return $this->hasOne(MasterCategoryPC::class,'id','category_id');
    }
}
