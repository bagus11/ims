<?php

namespace App\Http\Controllers\Transaction;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateProgressRequest;
use App\Models\Master\ApprovalModel;
use App\Models\Master\ProductModel;
use App\Models\Transaction\HistoryProduct_model;
use App\Models\Transaction\ItemRequestDetail;
use App\Models\Transaction\ItemRequestModel;
use App\Models\Transaction\PurchaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumConvert;
class PurchaseRequestController extends Controller
{
    function index() {
        return view('transaction.pr.pr-index');
    }
    function getPurchase() {
        $data = ItemRequestModel::with([
            'userRelation',
            'itemRelation',
            'locationRelation',
        ])->whereIn('request_type',[3,4])  
            ->orderBy('status','asc')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    function savePurchase(Request $request, StorePurchaseRequest $storePurchaseRequest) {
        try {
            $storePurchaseRequest->validated();
            $transaction_code ='';
            $increment_code = ItemRequestModel::orderBy('id','desc')->first();
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            $year = idate('y', $date_month);
            $month_convert =  NumConvert::roman($month);
            if($increment_code ==null){
                $transaction_code = '1/PUR/'.str_pad($request->location_id, 2, '0', STR_PAD_LEFT).'/'.$month_convert.'/'.$year;
            }else{
                $month_before = explode('/',$increment_code->request_code,-1);
                if($month_convert != $month_before[3]){
                    $transaction_code = '1/PUR/'.str_pad($request->location_id, 2, '0', STR_PAD_LEFT).'/'.$month_convert.'/'.$year;
                }else{
                    $transaction_code = $month_before[0] + 1 .'/PUR/'.str_pad($request->location_id, 2, '0', STR_PAD_LEFT).'/'.$month_convert.'/'.$year;
                }   
            }
            $fileName ='';
            if($request->file('attachment_req')){
                $ticketName = explode("/", $transaction_code);
                $ticketName2 = implode('',$ticketName);
                $custom_file_name = 'PUR-'.$ticketName2;
                $originalName = $request->file('attachment_req')->getClientOriginalExtension();
                $fileName =$custom_file_name.'.'.$originalName;
            }
            $destinationAttachment = $request->transaction_id == 1 ? 'storage/AttachmentRequest/'.$fileName : 'storage/AttachmentReturn/'.$fileName ;
            $approval_id = ApprovalModel::where([
                'category_id'   => $request->category_id,
                'location_id'   => $request->location_id
            ])->where('step',1)->first();
          
            $array_item=[];
            foreach($request->array_item as $row){
                $product_code = ProductModel::find($row['product_id']);
                $post_item =[
                    'request_code'          => $transaction_code,
                    'product_code'          => $product_code->product_code,
                    'quantity'              => $row['current_quantity'],
                    'quantity_request'      => $row['quantity_request'],
                    'quantity_final'        => $row['current_quantity'] + $row['quantity_request'] ,
                    'created_at'            => date('Y-m-d H:i:s')
                ];
                array_push($array_item, $post_item);
            }
            $post =[
                'request_code'         =>$transaction_code,
                'item_id'              =>'-',
                'quantity_request'     =>0,
                'location_id'          =>$request->location_id,
                'des_location_id'      =>$request->location_id,
                'request_type'         =>$request->transaction_id,
                'category_id'          => $request->category_id,
                'status'               =>1,
                'approval_status'      =>0,
                'user_id'              =>auth()->user()->id,
                'creator'              =>auth()->user()->id,
                'remark'               =>$request->comment,
                'approval_id'          =>$approval_id->user_id,
                'step'                 =>1,
                'attachment'           =>$destinationAttachment,
            ];
            $postLog=[
                'request_code'         =>$transaction_code,
                'item_id'              =>'-',
                'quantity_request'     =>0,
                'location_id'          =>$request->location_id,
                'request_type'         =>$request->transaction_id,
                'status'               =>1,
                'approval_status'      =>0,
                'step'                 =>1,
                'user_id'              =>auth()->user()->id,
                'creator'              =>auth()->user()->id,
                'des_location_id'      =>$request->location_id,
                'approval_id'          =>$approval_id->user_id,
                'comment'              => $request->comment
            ];
            $second_step =  ApprovalModel::where([
                'category_id'   => $request->category_id,
                'location_id'   => $request->location_id
            ])->where('step',$approval_id->step + 1)->first();
            $postSecond =[
                'request_code'         =>$transaction_code,
                'item_id'              =>'-',
                'quantity_request'     =>0,
                'location_id'          =>$request->location_id,
                'des_location_id'      =>$request->location_id,
                'request_type'         =>$request->transaction_id,
                'status'               =>2,
                'approval_status'      =>0,
                'user_id'              =>auth()->user()->id,
                'creator'              =>auth()->user()->id,
                'remark'               =>$request->comment,
                'approval_id'          =>$second_step->user_id,
                'step'                 =>2,
                'attachment'           =>$destinationAttachment,
            ];
            $postLogSecond=[
                'request_code'         =>$transaction_code,
                'item_id'              =>'-',
                'quantity_request'     =>0,
                'location_id'          =>$request->location_id,
                'request_type'         =>$request->transaction_id,
                'status'               =>2,
                'approval_status'      =>0,
                'step'                 =>2,
                'user_id'              =>auth()->user()->id,
                'creator'              =>auth()->user()->id,
                'des_location_id'      =>$request->location_id,
                'approval_id'          =>$second_step->user_id,
                'comment'              => $request->comment
            ];
            DB::transaction(function() use($post,$postLog,$request,$fileName,$array_item,$approval_id,$postSecond,$postLogSecond) {
                PurchaseModel::insert($array_item);
                ItemRequestDetail::create($postLog);
                if($approval_id->user_id == auth()->user()->id){
                    ItemRequestDetail::create($postLogSecond);
                    ItemRequestModel::create($postSecond);
                }else{
                    ItemRequestModel::create($post);

                }
            });
            return ResponseFormatter::success(   
                $post,                              
                'Your transaction successfully added, please wait for some approval,thanks'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Transaction failed to update',
                500
            );
        }
    }
    
    function detailPurchaseTransaction(Request $request) {
        $detail = ItemRequestModel::with([
            'userRelation',
            'itemRelation',
            'locationRelation',
            'desLocationRelation',
            'approvalRelation',
        ])->where('request_code',$request->id)->first();
        $countApproval = ApprovalModel::where('location_id',$request->des)->count();
        $log_item = PurchaseModel::with(
            [
                'itemRelation',
                'transactionRelation'
            ]
        )->where('request_code', $detail->request_code)->get();
        $log = ItemRequestDetail::with([
            'userRelation',
            'creatorRelation',
        ])->where('request_code',$request->id)->get();
        return response()->json([
            'detail'=>$detail,  
            'countApproval'=>$countApproval,  
            'log'=>$log,  
            'log_item'=>$log_item,  
        ]);  
    }
    function updateProgressPurchase(Request $request, UpdateProgressRequest $updateProgressRequest) {
        // try {
           $updateProgressRequest->validated();
           $dataOld             = ItemRequestDetail::where('request_code',$request->id)->orderBy('id','desc')->first();
           $purchaseOld         = PurchaseModel::where('request_code',$dataOld->request_code)->first();
            $productCode        = ProductModel::where('product_code',$purchaseOld->product_code)->first();
            $post_array         = [];
            $approval_id = ApprovalModel::where([
                'category_id'   => $productCode->category_id,
                'location_id'   => $dataOld->location_id
            ])->orderBy('step','desc')->first();
            // dd($approval_id->user_id);
           $post_log =[
               'request_code'      => $dataOld->request_code,
               'item_id'           => $dataOld->item_id,
               'quantity_request'  => $dataOld->quantity_request,
               'location_id'       => $dataOld->location_id,
               'request_type'      => $dataOld->request_type,
               'status'            => $request->update_approvalId,
               'checking'          => $request->update_approvalId == 6 ? 2 : 0,
               'creator'           => auth()->user()->id,
               'user_id'           => $dataOld->user_id,
               'approval_status'   => $dataOld->approval_status,
               'step'              => $dataOld->step,
               'des_location_id'   => $dataOld->des_location_id,
               'approval_id'       => $request->update_approvalId == 6 ?$approval_id->user_id: $dataOld->approval_id,
               'comment'           => $request->update_comment,
           ];
           $post =[
               'creator'           =>auth()->user()->id,
               'status'            => $request->update_approvalId,
               'checking'          => $request->update_approvalId == 6 ? 2 : 0,
               'step'              => $dataOld->step,
               'approval_id'       => $request->update_approvalId == 6 ?$approval_id->user_id: $dataOld->approval_id,
               'approval_status'   => $dataOld->approval_status,
           
           ];

           DB::transaction(function() use($post_array,$post_log,$request,$dataOld,$post) {
            $purchaseItem = PurchaseModel::where('request_code', $dataOld->request_code)->get(); 
            foreach($purchaseItem as $row){
                 $productModel = ProductModel :: where('product_code',$row->product_code)->first();
                 $postLogProduct =[
                     'product_code'         =>$row->product_code,
                     'request_code'         =>$request->id,
                     'source_location'      =>$dataOld->location_id,
                     'destination_location' =>$dataOld->des_location_id,
                     'quantity_request'     =>$row->quantity_request,
                     'quantity'             =>$productModel->quantity,
                     'quantity_result'      =>$productModel->quantity + $row->quantity_request,
                     'created_at'           =>date('Y-m-d H:i:s')   
                 ];
                 array_push($post_array,$postLogProduct);
                 ProductModel::where('product_code',$row->product_code)->update(['quantity'=>$productModel->quantity + $row->quantity_request]);
                }
                ItemRequestModel::where('request_code',$dataOld->request_code)->update($post);
                HistoryProduct_model::insert($post_array);
                ItemRequestDetail::create($post_log);
              
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
