<?php

namespace App\Http\Controllers\PettyCash\Transaction;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePettyCashRequest;
use App\Models\MasterLocation;
use App\Models\PettyCash\Master\ApprovalPCModel;
use App\Models\PettyCash\Master\MasterApproverPC;
use App\Models\PettyCash\Transaction\PettyCashRequest;
use App\Models\PettyCashModel;
use Illuminate\Http\Request;
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
            }else{
                $month_before = explode('/',$increment_code->pc_code,-1);
                if($month_convert != $month_before[3]){
                    $pc_code = '1/PC/'.$initialLocation->initial.'/'.$month_convert.'/'.$year;
                }else{
                    $pc_code = $month_before[0] + 1 .'/PC/'.$initialLocation->initial.'/'.$month_convert.'/'.$year;
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
            $post =[
                'pc_code'           => $pc_code,
                'amount'            => $total_amount,
                'category_id'       => $request->category_id,
                'status'            => 0,
                'user_id'           => auth()->user()->id,

            ];
            $getApprover = ApprovalPCModel::where('department_id', auth()->user()->departement)
                                            ->where('location_id', auth()->user()->kode_kantor)
                                            ->orderBy('step','asc')
                                            ->first();
            
            dd($array_post);
            if($request->file('attachment')){
                $request->file('attachment')->storeAs('/pr',$pc_code .'.pdf');
            }
          
        //     PettyCashModel::insert($array_post);
        //     return ResponseFormatter::success(   
        //         $request,                              
        //         'Petty Cash successfully added'
        //     );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Petty Cash failed to add',
        //         500
        //     );
        // }
    }

}
