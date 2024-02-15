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
use \Mpdf\Mpdf as PDF;

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
                'amount_remaining'          => $pettCash->amount_approve - $totalPayment ,
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
    function exportPI($pc_code_1){
      
        $data_pi        = '';
        $pc_code        = str_replace('_','/',$pc_code_1);
        $pi_code        = str_replace('PC','PI',$pc_code);
        // dd($pi_code);
        $data =[
            'data'=>$data_pi,
            'pi_code'=>$pi_code,
        ];
        $cetak              = view('pettycash.transaction.report.report_pi',$data);
        $imageLogo          = '<img src="'.public_path('icon.png').'" width="70px" style="float: right;"/>';
        $header             = '';
        $header             .= '<table width="100%">
                                    <tr>
                                        <td style="padding-left:10px;">
                                            <span style="font-size: 16px; font-weight: bold;"> PT PRALON</span>
                                            <br>
                                            <span style="font-size:9px;">Synergy Building #08-08 Tangerang 15143 - Indonesia +62 21 304 38808</span>
                                        </td>
                                        <td style="width:33%"></td>
                                            <td style="width: 50px; text-align:right;">'.$imageLogo.'
                                        </td>
                                    </tr>
                                    
                                </table>
                                <hr>';
        
        $footer             = '<hr>
                                <table width="100%" style="font-size: 10px;">
                                    <tr>
                                        <td width="90%" align="left"><b>Disclaimer</b><br>this document is strictly private, confidential and personal to recipients and should not be copied, distributed or reproduced in whole or in part, not passed to any third party.</td>
                                        <td width="10%" style="text-align: right;"> {PAGENO}</td>
                                    </tr>
                                </table>';

        
            $mpdf           = new PDF();
            $mpdf->SetHTMLHeader($header);
            $mpdf->SetHTMLFooter($footer);
            $mpdf->AddPage(
                'L', // L - landscape, P - portrait 
                '',
                '',
                '',
                '',
                5, // margin_left
                5, // margin right
                25, // margin top
                20, // margin bottom
                5, // margin header
                5
            ); // margin footer
            $mpdf->WriteHTML($cetak);
            // Output a PDF file directly to the browser
            ob_clean();
            $mpdf->Output('Report Stock'.'('.date('Y-m-d').').pdf', 'I');
    }
    function exportPC($pc_code_1){
      
        $pc_code        = str_replace('_','/',$pc_code_1);
        $data_pc        = PettyCashRequest::with([
            'categoryRelation',
            'locationRelation',
            'requesterRelation',
            'picRelation',
            'departmentRelation',
            'approvalRelation',
        ])->where('pc_code', $pc_code)->first();
        $dataProduct    = PettyCashSubcategory::with([
            'categoryRelation'
        ])->where('pc_code', $pc_code)->get();
        $cashier = ApprovalPCModel::with([
            'approvalRelation'
        ])->where([
            'location_id'       => $data_pc->location_id,
            'department_id'     => $data_pc->department
        ])->orderBy('id','desc')->first();
        // dd($cashier);
        $data =[
            'data'=>$data_pc,
            'pc_code'=>$pc_code,
            'cashier'=>$cashier,
            'dataProduct'=>$dataProduct,
        ];
        $cetak              = view('pettycash.transaction.report.report_pc',$data);
        $imageLogo          = '<img src="'.public_path('icon.png').'" width="70px" style="float: right;"/>';
        $header             = '';
        $header             .= '<table width="100%">
                                    <tr>
                                        <td style="padding-left:10px;">
                                            <span style="font-size: 16px; font-weight: bold;"> PT PRALON</span>
                                            <br>
                                            <span style="font-size:9px;">Synergy Building #08-08 Tangerang 15143 - Indonesia +62 21 304 38808</span>
                                        </td>
                                        <td style="width:33%"></td>
                                            <td style="width: 50px; text-align:right;">'.$imageLogo.'
                                        </td>
                                    </tr>
                                    
                                </table>
                                <hr>';
        
        $footer             = '<hr>
                                <table width="100%" style="font-size: 10px;">
                                    <tr>
                                        <td width="90%" align="left"><b>Disclaimer</b><br>this document is strictly private, confidential and personal to recipients and should not be copied, distributed or reproduced in whole or in part, not passed to any third party.</td>
                                        <td width="10%" style="text-align: right;"> {PAGENO}</td>
                                    </tr>
                                </table>';

        
            $mpdf           = new PDF();
            $mpdf->SetHTMLHeader($header);
            $mpdf->SetHTMLFooter($footer);
            $mpdf->AddPage(
                'L', // L - landscape, P - portrait 
                '',
                '',
                '',
                '',
                5, // margin_left
                5, // margin right
                25, // margin top
                20, // margin bottom
                5, // margin header
                5
            ); // margin footer
            $mpdf->WriteHTML($cetak);
            // Output a PDF file directly to the browser
            ob_clean();
            $mpdf->Output('Report Stock'.'('.date('Y-m-d').').pdf', 'I');
    }
}
