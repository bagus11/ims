<?php

namespace App\Http\Controllers\Master;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterApproverRequest;
use App\Http\Requests\UpdateApproverRequest;
use App\Http\Requests\UpdateMasterApproverRequest;
use App\Models\Master\ApprovalModel;
use App\Models\Master\CategoryModel;
use App\Models\Master\MasterApprover;
use App\Models\MasterDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterApproverController extends Controller
{
    function index() {
        return view('master.approver.approver-index');
    }
    function getApproval(Request $request) {
        $data = MasterApprover::with([
            'locationRelation',
            'categoryRelation',
        ])->get();
        return response()->json([
            'data'=>$data,  
        ]);  
    }

    function detailMasterApproval(Request $request) {
        $detail = MasterApprover::with([
            'locationRelation',
            'categoryRelation',
            'categoryRelation.departmentRelation',
        ])
        ->where('id',$request->id)
        ->first();
        return response()->json([
            'detail'=>$detail,  
        ]);  
    }
    function addMasterApproval(Request $request, StoreMasterApproverRequest $storeMasterApproverRequest) {
        try {
            $storeMasterApproverRequest->validated();
            $department = MasterDepartment::find($request->department_id);
            $ticket = $request->category_id.'-'.$department->initial.'-'.$request->location_id;
            $post =[
                'step'              => $request->step,
                'category_id'       => $request->category_id,
                'location_id'       => $request->location_id,
                'approval_id'       => $ticket
            ];
            MasterApprover::create($post);
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
    function editMasterApproval(Request $request, UpdateMasterApproverRequest $updateMasterApproverRequest) {
        try {
            $updateMasterApproverRequest->validated();
            $post =[
                'step'              => $request->edit_step,
            ];
            MasterApprover::find($request->id)->update($post);
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
    function getStepApproval(Request $request) {
        $data = ApprovalModel::with('approvalRelation')->where('approval_id',$request->approval_id)->get();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    function updateApprover(Request $request, UpdateApproverRequest $updateApproverRequest) {
        // try {
            $updateApproverRequest->validated();
            $validating = ApprovalModel::where('approval_id',$request->approval_id)->count();
            $array_post=[];
            foreach($request->user_array as $row){
                $location = MasterApprover::where('approval_id',$request->approval_id)->first(); 
                $post = [
                    'user_id'           => $row['user_id'],
                    'step'              => $row['step'],
                    'location_id'       => $location->location_id,
                    'category_id'       => $location->category_id,
                    'approval_id'       => $location->approval_id,
                ];
                array_push($array_post, $post);
            }
            DB::transaction(function() use($validating,$array_post,$request) {
                if($validating > 0){
                    ApprovalModel::where('approval_id',$request->approval_id)->delete();
                    ApprovalModel::insert($array_post);
                }else{
                    ApprovalModel::insert($array_post);
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
