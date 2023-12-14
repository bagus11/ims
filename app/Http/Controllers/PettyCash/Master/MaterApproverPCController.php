<?php

namespace App\Http\Controllers\PettyCash\Master;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterApproverPCRequest;
use App\Http\Requests\UpdateApproverPCRequest;
use App\Http\Requests\UpdateMasterApproverPCRequest;
use App\Models\MasterDepartment;
use App\Models\PettyCash\Master\ApprovalPCModel;
use App\Models\PettyCash\Master\MasterApproverPC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    function detailMasterApproverPC(Request $request) {
        $detail = MasterApproverPC::with(['departmentRelation','locationRelation'])->where('id',$request->id)->first();
        return response()->json([
            'detail'=>$detail,
        ]); 
    }
    function addMasterApproverPC(Request $request, StoreMasterApproverPCRequest $storeMasterApproverPCRequest) {
        try {
            $storeMasterApproverPCRequest->validated();
            $department = MasterDepartment::find($request->department_id);
            $ticket = $department->initial.'-'.$request->location_id;
            $post =[
                'step'              => $request->step,
                'location_id'       => $request->location_id,
                'approver_id'       => $ticket,
                'department_id'     => $request->department_id,
                'user_id'           => auth()->user()->id
            ];
            MasterApproverPC::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'Master Approver successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Master Approver failed to add',
                500
            );
        }
    }
    function editMasterApproverPC(Request $request, UpdateMasterApproverPCRequest $updateMasterApproverPCRequest) {
        try {
            $updateMasterApproverPCRequest->validated();
            $post =[
                'step'              => $request->edit_step,
            ];
            MasterApproverPC::find($request->id)->update($post);
            return ResponseFormatter::success(   
                $post,                              
                'Master Approver successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Master Approver failed to update',
                500
            );
        }
    }
    function getStepApproverPC(Request $request) {
        $data = ApprovalPCModel::with('approvalRelation')->where('approver_id',$request->approval_id)->get();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    function updateApproverPC(Request $request, UpdateApproverPCRequest $updateApproverRequest) {
        // try {
            $updateApproverRequest->validated();
            $validating = ApprovalPCModel::where('approver_id',$request->approval_id)->count();
            $array_post=[];
            foreach($request->user_array as $row){
                $location = MasterApproverPC::where('approver_id',$request->approval_id)->first(); 
                $post = [
                    'user_id'           => $row['user_id'],
                    'step'              => $row['step'],
                    'location_id'       => $location->location_id,
                    'approver_id'       => $request->approval_id,
                ];
                array_push($array_post, $post);
            }
            // dd($array_post);
            DB::transaction(function() use($validating,$array_post,$request) {
                if($validating > 0){
                    ApprovalPCModel::where('approver_id',$request->approval_id)->delete();
                    ApprovalPCModel::insert($array_post);
                }else{
                    ApprovalPCModel::insert($array_post);
                }
            });
            return ResponseFormatter::success(   
                $post,                              
                'Master Approver successfully updated'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Master Approver failed to update',
        //         500
        //     );
        // }
    }
    
}
