<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\InventoryAdjustment;
use Illuminate\Http\Request;

class InventoryAdjustmentController extends Controller
{
    function index() {
        return view('master.inventory_adjustment.inventory_adjustment-index');
    }
    function getInventoryAdjustment() {
        $data = InventoryAdjustment::with([
            'userRelation',
            'categoryRelation',
            'locationRelation'
        ])->get();
        return response()->json([
            'data'=>$data,  
          
        ]);  
    }
    function detailInventoryAdjustment(Request $request) {
        $detail = InventoryAdjustment::with([
            'userRelation',
            'categoryRelation',
            'locationRelation'
        ])->where('id',$request->id)->first();
        return response()->json([
            'detail'=>$detail,  
          
        ]);  
        
    }
}
