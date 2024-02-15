<?php

namespace App\Http\Controllers\PettyCash\Master;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePCRequest;
use App\Models\MasterBank;
use App\Models\PettyCash\Master\MasterPettyCash;
use App\Models\PettyCash\Master\PettyCashBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterPettyCashController extends Controller
{
    function index() {
        return view('pettycash.master.master_pettycash.master_pettycash-index');
    }
    function getMasterPC() {
        $data = MasterPettyCash::with(['bankRelation','locationRelation'])->get();
        return response()->json([
            'data'=>$data,
        ]); 
    }
    function addMasterPC(Request $request, StorePCRequest $storePCRequest) {
        // try {
            $storePCRequest->validated();
            $fileName           = '';
            $post =[
                'no_check'              => $request->no_check,
                'status'                => 1,
                'period'                => $request->period,
                'bank_id'               => $request->bank_id,
                'location_id'           => $request->location_id,
                'total_petty_cash'      => $request->total_pc,
                'user_id'               => auth()->user()->id,
                'attachment'            => 'storage/balance/'.date('YmdHis').'.pdf'
            ];
            $countBank      = PettyCashBank::where('location_id',$request->location_id)->count();
          
            if($countBank > 0){
                $getBank        = PettyCashBank::where('location_id',$request->location_id)->first();
                $postBank =[
                    'total_petty_cash'      => $getBank->total_petty_cash + $request->total_pc,
                ];
            }else{
                $postBank =[
                    'total_petty_cash'      => $request->total_pc,
                    'location_id'           => $request->location_id,
                    'buffer'                =>0
                ];
            }
            
            // dd($post);
            DB::transaction(function() use($post,$request,$postBank,$countBank) {
                if($request->file('attachment')){
                    $request->file('attachment')->storeAs('/balance',date('YmdHis').'.pdf');
                }
                MasterPettyCash::create($post);
                $countBank == 0 ? PettyCashBank::create($postBank) : PettyCashBank::where('location_id',$request->location_id)->update($postBank);

            });
            return ResponseFormatter::success(   
                $post,                              
                'Petty Cash successfully added'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Petty Cash failed to add',
        //         500
        //     );
        // }
    }
    function getActiveBank() {
        $data = MasterBank::where('status', 1)->get();
        return response()->json([
            'data'=>$data,
        ]); 
    }
    function getActivePettyCashBank() {
        $data='';
        if(auth()->user()->hasPermissionTo('get-only_gm-master_product')){
            $data = PettyCashBank::with([
                'locationRelation'
            ])->get();
        }else if(auth()->user()->hasPermissionTo('get-only_admin-pettycash_request')){
            $data = PettyCashBank::with([
                'locationRelation'
            ])->where('location_id',auth()->user()->kode_kantor)->get();

        }
        return response()->json([
            'data'=>$data,
        ]); 
    }
    function activatePC(Request $request) {
        try {
            $getMasterPettyCash = MasterPettyCash::where('no_check',$request->no_check)->first();
            $bank               = PettyCashBank::where('location_id', $getMasterPettyCash->location_id)->first();
            $total = 0;
            if($request->status == 1){
                $total          = $bank->total_petty_cash - $getMasterPettyCash->total_petty_cash;
            }else{
                $total          = $bank->total_petty_cash + $getMasterPettyCash->total_petty_cash;
            }
            $post =[
                'status'                => $request->status == 1 ? 0 : 1,
                'user_id'               => auth()->user()->id,
             
            ];
            $post_balance =[
                'total_petty_cash'      => $total
            ];
            // dd($post);
            MasterPettyCash::where('no_check',$request->no_check)->update($post);
            PettyCashBank::where('location_id', $getMasterPettyCash->location_id)->update($post_balance);
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
