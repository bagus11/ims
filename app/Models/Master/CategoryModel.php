<?php

namespace App\Models\Master;

use App\Models\MasterDepartment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;
    protected $table = 'category_model';
    protected $guarded = [];

    function typeRelation() {
        return $this->hasOne(TypeModel::class,'id','type_id');
    }
    function departmentRelation() {
        return $this->hasOne(MasterDepartment::class,'id','department_id');
    }
   
}
