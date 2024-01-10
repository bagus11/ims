<?php

namespace App\Http\Controllers\PettyCash\Transaction;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePettyCashRequest;
use App\Models\MasterLocation;
use App\Models\PettyCash\Master\ApprovalPCModel;
use App\Models\PettyCash\Master\MasterApproverPC;
use App\Models\PettyCash\Transaction\PettyCashDetail;
use App\Models\PettyCash\Transaction\PettyCashRequest;
use App\Models\PettyCash\Transaction\PettyCashSubcategory;
use App\Models\PettyCashModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumConvert;

class PettyCashRequestController extends Controller
{
    function index() {
        return view('pettycash.transaction.pettycash_request.pettycash_request-index');
    }
    function getPettyCashRequest() {
        $data = PettyCashRequest::with([
            'picRelation',
            'locationRelation',
            'categoryRelation',
        ])->get();
        return response()->json([
            'data'=>$data,
        ]); 
    }
    function detailPettyCashRequest(Request $request) {
        $detail = PettyCashRequest::with([
            'picRelation',
            'locationRelation',
            'categoryRelation',
            'requesterRelation',
            'approvalRelation',
        ])->where('id',$request->id)->first();
        $count = ApprovalPCModel::where([
            'location_id'       => $detail->location_id,
            'department_id'     => $detail->department
        ])->count();
        $data = PettyCashSubcategory::where('pc_code',$detail->pc_code)->get();
        return response()->json([
            'detail'=>$detail,
            'data'=>$data,
            'count'=>$count,
        ]); 
    }
    function addPettyCashRequest(Request $request, StorePettyCashRequest $storePettyCashRequest) {
        // try {
            $storePettyCashRequest->validated();
            $increment_code= PettyCashRequest::orderBy('id','desc')->first();
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            $year = idate('y', $date_month);
            $month_convert =  NumConvert::roman($month);
            $initialLocation  = MasterLocation::find(auth()->user()->kode_kantor);
            if($increment_code ==null){
                $pc_code = '1/PC/'.$initialLocation->initial.'/'.$month_convert.'/'.$year ;
                $attachmentLabel = '1_PC_'.$initialLocation->initial.'_'.$month_convert.'_'.$year ;
            }else{
                $month_before = explode('/',$increment_code->pc_code,-1);
                if($month_convert != $month_before[3]){
                    $pc_code = '1/PC/'.$initialLocation->initial.'/'.$month_convert.'/'.$year;
                    $attachmentLabel = '1_PC_'.$initialLocation->initial.'_'.$month_convert.'_'.$year;
                }else{
                    $pc_code = $month_before[0] + 1 .'/PC/'.$initialLocation->initial.'/'.$month_convert.'/'.$year;
                    $attachmentLabel = $month_before[0] + 1 .'_PC_'.$initialLocation->initial.'_'.$month_convert.'_'.$year;
                }   
            }
          
            $array_post =[];
            $array = json_decode($request->array_item, True); 
            $total_amount = 0;
                foreach($array as $row){
                    $post_subcategory =[
                                            'pc_code'               => $pc_code,
                                            'category_id'           => $request->category_id,
                                            'user_id'               => auth()->user()->id,
                                            'subcategory_id'        => $row['subcategoryId'],
                                            'amount'                => $row['amount'],
                                            'subcategory_name'      => $row['subcategory'],
                                        ];
                    $total_amount +=  $row['amount'];
                    array_push($array_post, $post_subcategory);
                }
                $getApprover = ApprovalPCModel::where('department_id', auth()->user()->departement)
                                                ->where('location_id', auth()->user()->kode_kantor)
                                                ->orderBy('step','asc')
                                                ->first();
            $post =[
                'pc_code'           => $pc_code,
                'amount'            => $total_amount,
                'category_id'       => $request->category_id,
                'status'            => 0,
                'user_id'           => auth()->user()->id,
                'pic_id'            => $request->pic_id,
                'approval_id'       => $getApprover->user_id,
                'department'        => auth()->user()->departement,
                'start_date'        => date('Y-m-d'),
                'end_date'          => date('Y-m-d'),
                'remark'            => $request->remark,
                'attachment'        => 'storage/pr/'.$attachmentLabel.'.pdf',
                'step'              => 1,
                'location_id'       => auth()->user()->kode_kantor
            ];
            $post_log =[
                'pc_code'           => $pc_code,
                'amount'            => $total_amount,
                'category_id'       => $request->category_id,
                'status'            => 0,
                'step'              => 1,
                'user_id'           => auth()->user()->id,
                'department'        => auth()->user()->departement,
                'pic_id'            => $request->pic_id,
                'approval_id'       => $getApprover->user_id,
                'start_date'        => date('Y-m-d'),
                'end_date'          => date('Y-m-d'),
                'remark'            => $request->remark,
                'creator'           => auth()->user()->id,
                'location_id'       => auth()->user()->kode_kantor
            ];

           DB::transaction(function() use($post_log,$post,$request,$array_post,$attachmentLabel) {
            PettyCashRequest::create($post);
            PettyCashDetail::create($post_log);
            PettyCashSubcategory::insert($array_post);
            if($request->file('attachment')){
                $request->file('attachment')->storeAs('/pr',$attachmentLabel .'.pdf');
            }
            });
            return ResponseFormatter::success(   
                $request,                              
                'Petty Cash successfully added, please wait for some approval. Thanks'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Petty Cash failed to add',
        //         500
        //     );
        // }
    }

}
