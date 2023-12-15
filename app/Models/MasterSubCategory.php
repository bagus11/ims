<?php

namespace App\Models;

use App\Models\PettyCash\Master\MasterCategoryPC;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSubCategory extends Model
{
    use HasFactory;
    protected $table = 'master_subcategory_pc';
    protected $guarded = [];
    function categoryRelation() {
        return $this->hasOne(MasterCategoryPC::class,'id','category_id');
    }
}
