<?php

namespace App\Http\Controllers\Transaction;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddTransactionRequest;
use App\Http\Requests\UpdateProgressRequest;
use App\Models\Master\ApprovalModel;
use App\Models\Master\ProductModel;
use App\Models\MasterLocation;
use App\Models\Transaction\HistoryProduct_model;
use App\Models\Transaction\ItemRequestDetail;
use App\Models\Transaction\ItemRequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumConvert;
class ItemRequestController extends Controller
{
    function index() {
        return view('transaction.ir.ir-index');
    }
    function getItemRequest(Request $request) {
        // dd(auth()->user()->roles->pluck('name')); 
        if(auth()->user()->hasPermissionTo('get-only_user-item_request')){
           
            $data = ItemRequestModel::with([
                'userRelation',
                'itemRelation',
                'locationRelation',
            ])->where('location_id','like','%'.$request->id.'%')
                ->whereIn('request_type',[1,2,3])
                ->orderBy('status','asc')
                ->orderBy('id', 'desc')
                ->where('user_id', auth()->user()->id)
                ->get();
            return response()->json([
                'data'=>$data,  
            ]);  
        }else if(auth()->user()->hasPermissionTo('get-only_admin-item_request')){
            //  dd(auth()->user()->id);
            $data = ItemRequestModel::with([
                'userRelation',
                'itemRelation',
                'stepRelation',
                'locationRelation',
                'approvalRelation',
                ])->where('location_id','like','%'.$request->id.'%')
                ->whereHas('stepRelation',function($q){
                    $q->where('user_id', auth()->user()->id);
                })
                ->orWhere('user_id',auth()->user()->id)
                ->whereIn('request_type',[1,2,3])
                ->orderBy('status','asc')
                ->orderBy('id', 'desc')
                ->get();
            return response()->json([
                'data'=>$data,  
            ]);  
        }else{
            $data = ItemRequestModel::with([
                'userRelation',
                'itemRelation',
                'stepRelation',
                'locationRelation',
                'approvalRelation',
            ])->where('location_id','like','%'.$request->id.'%')
                ->whereIn('request_type',[1,2,3])
                ->orderBy('status','asc')
                ->orderBy('id', 'desc')
                ->get();
            return response()->json([
                'data'=>$data,  
            ]);   
        }
    }
    function detailTransaction(Request $request) {
        $detail = ItemRequestModel::with([
            'userRelation',
            'itemRelation',
            'locationRelation',
            'desLocationRelation',
            'approvalRelation',
        ])->where('request_code',$request->id)->first();
        $countApproval = ApprovalModel::where('location_id',$request->des)->count();
        $log = ItemRequestDetail::with([
            'userRelation',
            'creatorRelation',
        ])->where('request_code',$request->id)->get();
        return response()->json([
            'detail'=>$detail,  
            'countApproval'=>$countApproval,  
            'log'=>$log,  
        ]);  
    }
    function addTransaction(Request $request, AddTransactionRequest $addTransactionRequest) {
        // try {
            $addTransactionRequest->validated();
            $transaction_code ='';
            $transactionType = '';
            if($request->transaction_id == 1 ){
                $transactionType = 'REQ';
            }else if($request->transaction_id == 2){
                $transactionType = 'RET';
            }else{
                $transactionType = 'DIS';
            }
            $increment_code = ItemRequestModel::orderBy('id','desc')->first();
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            $year = idate('y', $date_month);
            $month_convert =  NumConvert::roman($month);
            if($increment_code ==null){
                $transaction_code = '1/'.$transactionType.'/'.str_pad($request->location_id, 2, '0', STR_PAD_LEFT).'/'.$month_convert.'/'.$year;
            }else{
                $month_before = explode('/',$increment_code->request_code,-1);
                if($month_convert != $month_before[3]){
                    $transaction_code = '1/'.$transactionType.'/'.str_pad($request->location_id, 2, '0', STR_PAD_LEFT).'/'.$month_convert.'/'.$year;
                }else{
                    $transaction_code = $month_before[0] + 1 .'/'.$transactionType.'/'.str_pad($request->location_id, 2, '0', STR_PAD_LEFT).'/'.$month_convert.'/'.$year;
                }   
            }
            $fileName ='';
            if($request->file('attachment_req')){
                $ticketName = explode("/", $transaction_code);
                $ticketName2 = implode('',$ticketName);
                $custom_file_name = $transactionType.'-'.$ticketName2;
                $originalName = $request->file('attachment_req')->getClientOriginalExtension();
                $fileName =$custom_file_name.'.'.$originalName;
            }
            $destinationAttachment = $request->transaction_id == 1 ? 'storage/AttachmentRequest/'.$fileName : 'storage/AttachmentReturn/'.$fileName ;
            $productCode = ProductModel::find($request->product_id);
            $approval_id = ApprovalModel::where([
                'category_id'   => $productCode->category_id,
                'location_id'   => $request->location_id
            ])->where('step',1)->first();
            $post =[
                'request_code'         =>$transaction_code,
                'item_id'              =>$productCode->product_code,
                'quantity_request'     =>$request->quantity_request,
                'location_id'          =>$request->location_id,
                'des_location_id'      =>$request->location_id,
                'request_type'         =>$request->transaction_id,
                'remark'               =>$request->comment,
                'category_id'          =>$productCode->category_id,
                'status'               =>1,
                'checking'             =>0,
                'approval_status'      =>0,
                'user_id'              =>auth()->user()->id,
                'creator'              =>auth()->user()->id,
                'approval_id'          =>$approval_id->user_id,
                'step'                 =>1,
                'attachment'           =>$destinationAttachment,
            ];
            $postLog=[
                'request_code'         =>$transaction_code,
                'item_id'              =>$productCode->product_code,
                'quantity_request'     =>$request->quantity_request,
                'location_id'          =>$request->location_id,
                'request_type'         =>$request->transaction_id,
                'status'               =>1,
                'checking'             =>0,
                'approval_status'      =>0,
                'step'                 =>1,
                'user_id'              =>auth()->user()->id,
                'creator'              =>auth()->user()->id,
                'des_location_id'      =>$request->location_id,
                'approval_id'          =>$approval_id->user_id,
                'comment'              => $request->comment
            ];
            if ($request->hasFile('image')) {
                $request->file('attachment_req')->storeAs('/attachment/',$fileName);
            }
            $second_approval = ApprovalModel::where([
                'category_id'   => $productCode->category_id,
                'location_id'   => $request->location_id
            ])->where('step', $approval_id->step + 1)->first();
            $postLogSecond=[
                'request_code'         =>$transaction_code,
                'item_id'              =>$productCode->product_code,
                'quantity_request'     =>$request->quantity_request,
                'location_id'          =>$request->location_id,
                'request_type'         =>$request->transaction_id,
                'status'               =>2,
                'checking'             =>0,
                'approval_status'      =>0,
                'step'                 =>2,
                'user_id'              =>auth()->user()->id,
                'creator'              =>auth()->user()->id,
                'des_location_id'      =>$request->location_id,
                'approval_id'          =>$second_approval->user_id,
                'comment'              =>'this transaction has been approved by system'
            ];
            $postSecond =[
                'request_code'         =>$transaction_code,
                'item_id'              =>$productCode->product_code,
                'quantity_request'     =>$request->quantity_request,
                'location_id'          =>$request->location_id,
                'des_location_id'      =>$request->location_id,
                'category_id'          =>$productCode->category_id,
                'request_type'         =>$request->transaction_id,
                'remark'                =>$request->comment,
                'status'               =>2,
                'checking'             =>0,
                'approval_status'      =>0,
                'user_id'              =>auth()->user()->id,
                'creator'              =>auth()->user()->id,
                'approval_id'          =>$second_approval->user_id,
                'step'                 =>2,
                'attachment'           =>$destinationAttachment,
            ];
            // dd($post);
            DB::transaction(function() use($post,$postLog,$request,$fileName,$approval_id,$postSecond,$postLogSecond) {
                ItemRequestDetail::create($postLog);
                if($approval_id->user_id == auth()->user()->id){
                    ItemRequestModel::create($postSecond);
                    ItemRequestDetail::create($postLogSecond);
                }else{
                    ItemRequestModel::create($post);
                }
                if($request->file('attachment_req')){
                    $destination = $request->transaction_id == 1 ?'/AttachmentRequest/' :'/AttachmentReturn/';
                    $request->file('attachment_req')->storeAs('/attachment/',$fileName);
                }
                
            });
            
            return ResponseFormatter::success(   
                $post,                              
                'Your transaction successfully added, please wait for some approval,thanks'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Transaction failed to update',
        //         500
        //     );
        // }
    }
    function updateProgress(Request $request, UpdateProgressRequest $updateProgressRequest) {
         // try {
            $updateProgressRequest->validated();
            $dataOld            = ItemRequestDetail::where('request_code',$request->id)->orderBy('id','desc')->first();
            $updateProduct      = ProductModel::where('product_code', $dataOld->item_id)->first();  
            $finalItem          = $dataOld->request_type == 1 || $dataOld->request_type == 3 ?  $updateProduct->quantity - $dataOld->quantity_request : $updateProduct->quantity + $dataOld->quantity_request;
            $productCode        = ProductModel::where('product_code',$dataOld->item_id)->first();
            $approval_id        = ApprovalModel::where([
                'category_id'   => $productCode->category_id,
                'location_id'   => $dataOld->location_id
            ])->orderBy('step','desc')->first();
           
            $post_log =[
                'request_code'      => $dataOld->request_code,
                'item_id'           => $dataOld->item_id,
                'quantity_request'  => $dataOld->quantity_request,
                'location_id'       => $dataOld->location_id,
                'request_type'      => $dataOld->request_type,
                'status'            => $request->update_approvalId ,
                'checking'          => $request->update_approvalId == 6 ? 2 : 0 ,
                'creator'           => auth()->user()->id,
                'user_id'           => $dataOld->user_id,
                'approval_status'   => $dataOld->approval_status,
                'step'              => $dataOld->step,
                'des_location_id'   => $dataOld->des_location_id,
                'approval_id'       => $request->update_approvalId == 6 ?$approval_id->user_id: $dataOld->approval_id,
                'comment'           => $request->update_comment,
            ];
            $post =[
                'creator'           => auth()->user()->id,
                'status'            => $request->update_approvalId ,
                'checking'          => $request->update_approvalId == 6 ? 2 : 0 ,
                'step'              => $dataOld->step,
                'approval_id'       => $request->update_approvalId == 6 ?$approval_id->user_id: $dataOld->approval_id,
                'approval_status'   => $dataOld->approval_status,
            
            ];
            $postLogProduct =[
                'product_code' =>$dataOld->item_id,
                'request_code' =>$dataOld->request_code,
                'source_location' =>$dataOld->location_id,
                'destination_location' =>$dataOld->des_location_id,
                'quantity_request' =>$dataOld->quantity_request,
                'quantity' =>$updateProduct->quantity,
                'quantity_result' =>$finalItem,
            ];
            $updatePost =[
                'quantity'=>$finalItem
            ];
               
    
            DB::transaction(function() use($post,$post_log,$request,$dataOld,$postLogProduct,$updatePost,$updateProduct) {

                ItemRequestModel::where('request_code',$request->id)->update($post);
                ItemRequestDetail::create($post_log);
                $updateProduct->update($updatePost);
                  HistoryProduct_model::create($postLogProduct);
            });
            return ResponseFormatter::success(   
                $post_log,                              
                'Transaction successfully updated'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Transaction failed to update',
        //         500
        //     );
        // }
        
    }
}
