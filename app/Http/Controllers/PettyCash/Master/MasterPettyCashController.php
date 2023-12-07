<?php

namespace App\Http\Controllers\PettyCash\Master;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePCRequest;
use App\Models\PettyCash\Master\MasterPettyCash;
use Illuminate\Http\Request;

class MasterPettyCashController extends Controller
{
    function index() {
        return view('pettycash.master.master_pettycash.master_pettycash-index');
    }
    function getMasterPC() {
        $data = MasterPettyCash::all();
        return response()->json([
            'data'=>$data,
        ]); 
    }
    function addMasterPC(Request $request, StorePCRequest $storePCRequest) {
        try {
            $storePCRequest->validated();
            $post =[
                'no_check'              => $request->no_check,
                'status'                => 1,
                'period'                =>$request->period,
                'total_petty_cash'      =>$request->total_pc,
                'user_id'               =>auth()->user()->id,
            ];
            // dd($post);
            MasterPettyCash::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'Petty Cash successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Petty Cash failed to add',
                500
            );
        }
    }
    function activatePC(Request $request) {
        try {
           
            $post =[
                'status'                => $request->status == 1 ? 0 : 1,
                'user_id'               =>auth()->user()->id,
            ];
            // dd($post);
            MasterPettyCash::where('no_check',$request->no_check)->update($post);
            return ResponseFormatter::success(   
                $post,                              
                'Petty Cash successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Petty Cash failed to update',
                500
            );
        }
    }
}
