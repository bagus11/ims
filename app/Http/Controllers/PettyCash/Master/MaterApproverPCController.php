<?php

namespace App\Http\Controllers\PettyCash\Master;

use App\Http\Controllers\Controller;
use App\Models\PettyCash\Master\MasterApproverPC;
use Illuminate\Http\Request;

class MaterApproverPCController extends Controller
{
    function index() {
        return view('pettycash.master.master_approver.master_approver_pc-index');
    }
    function getApproverPC() {
        $data = MasterApproverPC::with(['departmentRelation','locationRelation'])->get();
        return response()->json([
            'data'=>$data,
        ]); 
    }
    function addMasterApproverPC() {
        
    }
}
