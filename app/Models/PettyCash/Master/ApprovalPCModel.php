<?php

namespace App\Models\PettyCash\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalPCModel extends Model
{
    use HasFactory;
    protected $table = 'approval_pc_model';
    protected $guarded = [];
}
