<?php

namespace App\Http\Controllers\PettyCash\Transaction;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAssignmentPCRequest;
use App\Models\PettyCash\Master\ApprovalPCModel;
use App\Models\PettyCash\Transaction\PettyCashDetail;
use App\Models\PettyCash\Transaction\PettyCashRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentPettyCashController extends Controller
{
    function index() {
        return view('pettycash.transaction.assignment.assignment-index');
    }
    function getAssignmentPC() {
        $data = PettyCashRequest::with([
            'picRelation',
            'locationRelation',
            'categoryRelation',
        ])->whereIn('status', [0,1,3,4])->where('approval_id', auth()->user()->id)->get();
        return response()->json([
            'data'=>$data,
        ]); 
    }
    function getHistoryRemark(Request $request) {
        $data = PettyCashDetail::with([
            'creatorRelation',
        ])->where('pc_code',$request->pc_code)->get();
        return response()->json([
            'data'=>$data,
        ]); 
    }
    function updateApprovalPC(Request $request, UpdateAssignmentPCRequest $updateAssignmentPCRequest) {
        //  try {
            $updateAssignmentPCRequest->validated();
            $dataOld        = PettyCashDetail ::where('pc_code',$request->pc_code)->orderBy('id','desc')->first();
            $dataOld2       = PettyCashRequest ::where('pc_code',$request->pc_code)->first();
            $step_approval  = $dataOld->step == 1 ? $dataOld->step + 1 : $dataOld->step + 1;
            $next_approver  = ApprovalPCModel::where([
                'department_id'    => $dataOld->department,
                'location_id'   => $dataOld->location_id,
                'step'          => $step_approval 
            ])->first();
           
            $count_approval =  ApprovalPCModel::where([
                'department_id'    => $dataOld->department,
                'location_id'   => $dataOld->location_id
            ])->count();
            $status =0;
            $approval_id = $next_approver ? $next_approver->user_id : 0;
            $approval_status = $request->approval_id;
            $step ='';
            // dd($dataOld2);
            if($request->approval_id == 1){
                if($dataOld->status == 1){
                    if($dataOld->step == $count_approval){
                        $status         = $dataOld->status + 1;
                        $end_date       = Carbon::create($request->start_date_input);
                        $subdays        = $end_date->addDays(7);

                        $post =[
                            'status'            => $status,
                            'approval_id'       => $approval_id,
                            'amount_approve'    => $request->amount_assign,
                            'start_date'        => $request->start_date_input,
                            'end_date'          => $subdays->toDateString(),
                            'step'              => $step_approval,
                            'updated_at'        => date('Y-m-d H:i:s')
                        ];

                    }else{
                        $status = $dataOld->status;
                        $post =[
                            'status'            => $status,
                            'approval_id'       => $approval_id,
                            'step'              => $step_approval,
                            'updated_at'        => date('Y-m-d H:i:s')
                        ];
                    }
                }else if($dataOld2->status == 3 && $dataOld2->step_app_pi == 1){
                    // Approval ke pak vincent
                        $status = $dataOld->status;
                        $approval_id = 1570;
                        $post =[
                            'status'            => $status,
                            'approval_id'       => $approval_id,
                            'step'              => $step_approval,
                            'updated_at'        => date('Y-m-d H:i:s'),
                            'step_app_pi'       => $dataOld2->step_app_pi + 1
                        ];
                    // Approval ke pak vincent
                }else if($dataOld2->status == 3 && $dataOld2->step_app_pi == 2){
                    // Approval Finalisasi ke Cashier
                        $status = $dataOld->status + 1;
                        $approvalLast = ApprovalPCModel::where('department_id',$dataOld2->department)->where('location_id',$dataOld2->location_id)->orderBy('step','desc')->first();
                        $approval_id = $approvalLast->user_id;
                        $step_approval = 0;
                        $post =[
                            'status'            => $status,
                            'approval_id'       => $approval_id,
                            'step'              => $step_approval,
                            'updated_at'        => date('Y-m-d H:i:s'),
                            'step_app_pi'       => $dataOld2->step_app_pi + 1
                        ];
                    // Approval Finalisasi ke Cashier
                }else if($dataOld2->status == 4){
                    // Finalisasi Cashier  
                    dd('test');
                    // Finalisasi Cashier
                }
                else{
                    $status = $dataOld->status + 1;
                    $post =[
                        'status'            => $status,
                        'approval_id'       => $approval_id,
                        'step'              => $step_approval,
                        'updated_at'        => date('Y-m-d H:i:s')
                    ];
                }
            }else{
                $status = 5;
            }
            $post_log =[
                'pc_code'           => $dataOld->pc_code,
                'amount'            => $dataOld->amount,
                'category_id'       => $dataOld->category_id,
                'status'            => $status,
                'user_id'           => $dataOld->user_id,
                'department'        => $dataOld->department,
                'pic_id'            => $dataOld->pic_id,
                'approval_id'       => $approval_id,
                'start_date'        => date('Y-m-d'),
                'end_date'          => date('Y-m-d'),
                'remark'            => $request->remark,
                'location_id'       => $dataOld->location_id,
                'step'              => $step_approval,
                'creator'           => auth()->user()->id
            ];
          
            // dd($post);
            DB::transaction(function() use($post,$post_log,$dataOld) {
                PettyCashRequest::where('pc_code',$dataOld->pc_code)->update($post);
                PettyCashDetail::create($post_log);
            });
            return ResponseFormatter::success(   
                $post,                              
                'Assignment successfully updated'
            );        
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Assignment failed to update',
        //         500
        //     );
        // }
    }
}
