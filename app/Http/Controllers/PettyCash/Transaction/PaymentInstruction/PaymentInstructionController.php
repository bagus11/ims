<?php

namespace App\Http\Controllers\PettyCash\Transaction\PaymentInstruction;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\addPaymentInstructionRequest;
use App\Models\Master\ApprovalModel;
use App\Models\PettyCash\Master\ApprovalPCModel;
use App\Models\PettyCash\Transaction\PaymentInstructionDetail;
use App\Models\PettyCash\Transaction\PaymentInstructionModel;
use App\Models\PettyCash\Transaction\PettyCashDetail;
use App\Models\PettyCash\Transaction\PettyCashRequest;
use App\Models\PettyCash\Transaction\PettyCashSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentInstructionController extends Controller
{
    function addPaymentInstruction(Request $request) {
        // try {
            // $addPaymentInstructionRequest->validated();
           
            $arrayAmount = json_decode($request->amount, True); 
            $post_array = [];
            $subcategory = PettyCashSubcategory::where('pc_code', $request->pc_code_id_pi)->get();
            $pettCash   = PettyCashRequest::where('pc_code', $request->pc_code_id_pi)->first();
            $pi_code = str_replace('/PC/','/PI/',$request->pc_code_id_pi);
            $totalPayment = 0;
            $attachmentName =[];
            for($i = 0; $i < count($arrayAmount); $i++){
                $attachmentReplace = str_replace('/','',$pi_code);
                $post =[
                    'pi_code'                   => $pi_code,
                    'pc_code'                   => $request->pc_code_id_pi,
                    'user_id'                   => auth()->user()->id,
                    'subcategory_id'            => $subcategory[$i]->subcategory_id,   
                    'subcategory_name'          => $subcategory[$i]->subcategory_name,   
                    'subcategory_amount'        => $subcategory[$i]->amount,   
                    'payment'                   => $arrayAmount[$i],   
                    'attachment'                => 'storage/pi/'.$attachmentReplace.'_'.$i.'.pdf',
                ];
                array_push($post_array, $post);
                $post_name =[
                    'name'                      => $attachmentReplace.'_'.$i
                ];
                array_push($attachmentName, $post_name);
                $totalPayment += $arrayAmount[$i];
            }
            $approvalCount = ApprovalPCModel::where('department_id',auth()->user()->departement)->where('location_id',auth()->user()->kode_kantor)->count();
            $approvalRequest = ApprovalPCModel::where('department_id',auth()->user()->departement)->where('location_id',auth()->user()->kode_kantor)->where('step', $approvalCount - 1)->first();
            $approval_id = $approvalCount == 1 ? 1 : $approvalRequest->user_id;
            
          
            $post_pi =[
                'pi_code'                   => $pi_code,
                'pc_code'                   => $request->pc_code_id_pi,
                'amount_request'            => $pettCash->amount,
                'amount_approve'            => $pettCash->amount_approve,
                'payment'                   => $totalPayment,
                'amount_remaining'          => $pettCash->amount_approve - $totalPayment ,
                'user_id'                   => auth()->user()->id,
                'pic_id'                => $pettCash->pic_id,
                'approval_id'               => $approval_id,
                'status'                    => $pettCash->status + 1,

            ];
            // dd($attachmentName);
            $post_pc =[
                'status'                    => $pettCash->status + 1,
                'approval_id'               => $approval_id,
                'step_app_pi'               => 1,
            ];
            $post_pc_log =[
                 
                'pc_code'           => $pettCash->pc_code,
                'amount'            => $pettCash->amount,
                'category_id'       => $pettCash->category_id,
                'status'            => $pettCash->status + 1,
                'step'              => $approvalCount == 1 ? 1 : $approvalCount,
                'user_id'           => $pettCash->user_id,
                'department'        => $pettCash->department,
                'pic_id'            => $pettCash->pic_id,
                'approval_id'       => $pettCash->approval_id,
                'start_date'        => $pettCash->start_date,
                'end_date'          => $pettCash->end_date,
                'remark'            => $request->remark_pi,
                'creator'           => auth()->user()->id,
                'location_id'       => $pettCash->location_id
            ];
            DB::transaction(function() use($post_pc_log,$post_pc,$request,$post_pi,$post_array,$attachmentName) {
                PettyCashRequest::where('pc_code',$request->pc_code_id_pi)->update($post_pc);
                PettyCashDetail::create($post_pc_log);
                PaymentInstructionModel::create($post_pi);
                PaymentInstructionDetail::insert($post_array);
                
                $j = 0;
                foreach ($request->file('attachment_pi') as $file) {
                    $file->storeAs('/pi', $attachmentName[$j]['name'] . '.pdf');
                    $j++;
                }
            });
           
            return ResponseFormatter::success(   
                $request,                              
                'Payment Instruction successfully added, please wait for some approval. Thanks'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Payment Instruction failed to add',
        //         500
        //     );
        // }
    }
}
