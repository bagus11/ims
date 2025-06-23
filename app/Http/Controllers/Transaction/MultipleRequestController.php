<?php

namespace App\Http\Controllers\Transaction;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdateProgressRequest;
use App\Models\Master\ApprovalModel;
use App\Models\Master\MasterApprover;
use App\Models\Master\ProductModel;
use App\Models\Transaction\HistoryProduct_model;
use App\Models\Transaction\ItemRequestDetail;
use App\Models\Transaction\ItemRequestModel;
use App\Models\Transaction\PurchaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumConvert;
class MultipleRequestController extends Controller
{
    function index() {
        return view('transaction.multiple_request.multiple_request-index');
    }
    function addMultipleTransaction(Request $request, StorePurchaseRequest $storePurchaseRequest) {
        $storePurchaseRequest->validated();
        $transaction_code ='';
        $transactionType = '';
        $array_item=[];
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
                $custom_file_name = 'PUR-'.$ticketName2;
                $originalName = $request->file('attachment_req')->getClientOriginalExtension();
                $fileName =$custom_file_name.'.'.$originalName;
            }
            $destinationAttachment = $request->transaction_id == 1 ? 'storage/AttachmentRequest/'.$fileName : 'storage/AttachmentReturn/'.$fileName ;
            $approval_id = ApprovalModel::where([
                'category_id'   => $request->category_id,
                'location_id'   => $request->location_id
            ])->where('step',1)->first();
            foreach($request->array_item as $row){
                $product_code = ProductModel::find($row['product_id']);
                $post_item =[
                    'request_code'          => $transaction_code,
                    'product_code'          => $product_code->product_code,
                    'quantity'              => $row['current_quantity'],
                    'quantity_request'      => $row['quantity_request'],
                    'quantity_final'        => $row['current_quantity'] - $row['quantity_request'] ,
                    'created_at'            => date('Y-m-d H:i:s')
                ];
                array_push($array_item, $post_item);
            }
            $post =[
                'request_code'         =>$transaction_code,
                'item_id'              =>'-',
                'quantity_request'     =>0,
                'location_id'          =>$request->location_id,
                'des_location_id'      =>auth()->user()->kode_kantor,
                'request_type'         =>$request->transaction_id,
                'remark'               =>$request->comment,
                'category_id'          =>$request->category_id,
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
                'item_id'              =>'-',
                'quantity_request'     =>0,
                'location_id'          =>$request->location_id,
                'request_type'         =>$request->transaction_id,
                'status'               =>1,
                'checking'             =>0,
                'approval_status'      =>0,
                'step'                 =>1,
                'user_id'              =>auth()->user()->id,
                'creator'              =>auth()->user()->id,
                'des_location_id'      =>auth()->user()->kode_kantor,
                'approval_id'          =>$approval_id->user_id,
                'comment'              => $request->comment
            ];
            // dd(auth()->user()->kode_kantor);
            $second_approval='';
            DB::transaction(function() use($post,$postLog,$request,$transaction_code,$fileName,$array_item,$approval_id,$second_approval) {
                PurchaseModel::insert($array_item);
                ItemRequestDetail::create($postLog);
                foreach($request->array_item as $row){
                    // dd($row);
                    $productCode = ProductModel::find($row['product_id']);
                    ProductModel::find($row['product_id'])->update(
                        [
                            'quantity_buffer' => $productCode->quantity_buffer + $row['quantity_request']
                        ]
                    );
                }
                if($approval_id->user_id == auth()->user()->id){
                    $second_approval = ApprovalModel::where([
                        'category_id'   => $request->category_id,
                        'location_id'   => $request->location_id
                    ])->where('step', $approval_id->step + 1)->first();
                    $stepApproval =  MasterApprover::where([
                        'category_id'   => $request->category_id,
                        'location_id'   => $request->location_id
                    ])->first();
                    // dd($stepApproval->step,$second_approval);
                    $postLogSecond=[
                        'request_code'         =>$transaction_code,
                        'item_id'              =>'-',
                        'quantity_request'     =>0,
                        'location_id'          =>$request->location_id,
                        'request_type'         =>$request->transaction_id,
                        'status'               =>$stepApproval->step == 1 ? 3 : 2,
                        'checking'             =>0,
                        'approval_status'      =>0,
                        'step'                 =>2,
                        'user_id'              =>auth()->user()->id,
                        'creator'              =>auth()->user()->id,
                        'des_location_id'      =>auth()->user()->kode_kantor,
                        'approval_id'          =>$second_approval == null ? auth()->user()->id : $second_approval->user_id,
                        'comment'              =>'this transaction has been approved by system'
                    ];
                    $postSecond =[
                        'request_code'         =>$transaction_code,
                        'item_id'              =>'-',
                        'quantity_request'     =>0,
                        'location_id'          =>$request->location_id,
                        'des_location_id'      =>auth()->user()->kode_kantor,
                        'category_id'          =>$request->category_id,
                        'request_type'         =>$request->transaction_id,
                        'remark'                =>$request->comment,
                        'status'               =>$stepApproval->step == 1 ? 3 : 2,
                        'checking'             =>0,
                        'approval_status'      =>0,
                        'user_id'              =>auth()->user()->id,
                        'creator'              =>auth()->user()->id,
                         'approval_id'          =>$second_approval == null ? auth()->user()->id : $second_approval->user_id,
                        'step'                 =>2,
                        'attachment'           =>'',
                    ];
                    // dd($postSecond);
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
                'Transaction successfully updated'
            );    
    }
    function updateProgressMultiple(Request $request, UpdateProgressRequest $updateProgressRequest) {
        $updateProgressRequest->validated();
        $dataOld             = ItemRequestDetail::where('request_code',$request->id)->orderBy('id','desc')->first();
        $purchaseOld         = PurchaseModel::where('request_code',$dataOld->request_code)->first();
     //    dd($purchaseOld);
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
              $finalBuffer        = $dataOld->request_type == 1 || $dataOld->request_type == 3 ?  $productModel->quantity_buffer - $row['quantity_request'] : $productModel->quantity + $dataOld->quantity_request;
              $finalResult =  $dataOld->request_type == 1 || $dataOld->request_type == 3 ? $productModel->quantity - $row->quantity_request : $productModel->quantity + $row->quantity_request;
            //   dd($finalResult);
              $postLogProduct =[
                  'product_code'         =>$row->product_code,
                  'request_code'         =>$request->id,
                  'source_location'      =>$dataOld->location_id,
                  'destination_location' =>$dataOld->des_location_id,
                  'quantity_request'     =>$row->quantity_request,
                  'quantity'             =>$productModel->quantity,
                  'quantity_result'      =>$finalResult,
                  'created_at'           =>date('Y-m-d H:i:s')   
              ];
              array_push($post_array,$postLogProduct);
             
              ProductModel::where('product_code',$row->product_code)->update([
                'quantity'=>$finalResult,
                'quantity_buffer'=>$finalBuffer
            
            ]);
             }
             ItemRequestModel::where('request_code',$dataOld->request_code)->update($post);
             HistoryProduct_model::insert($post_array);
             ItemRequestDetail::create($post_log);
           
        });
        return ResponseFormatter::success(   
            $post,                              
            'Transaction successfully updated'
        );    
    }
}
