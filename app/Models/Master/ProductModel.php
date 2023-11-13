<?php

namespace App\Models\Master;

use App\Models\MasterDepartment;
use App\Models\MasterLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = 'product_model';

    protected $guarded = [];
    function typeRelation() {
        return $this->hasOne(TypeModel::class,'id','type_id');
    }
    function categoryRelation() {
        return $this->hasOne(CategoryModel::class,'id','category_id');
    }
    function locationRelation() {
        return $this->hasOne(MasterLocation::class,'id','location_id');
    }
    function departmentRelation() {
        return $this->hasOne(MasterDepartment::class,'id','department_id');
    }
 
}
