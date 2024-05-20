<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePurchaseRequest;
use App\Models\Master\ApprovalModel;
use App\Models\Master\ProductModel;
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
                'des_location_id'      =>$request->location_id,
                'approval_id'          =>$approval_id->user_id,
                'comment'              => $request->comment
            ];
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
                
                    $postLogSecond=[
                        'request_code'         =>$transaction_code,
                        'item_id'              =>'-',
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
                        'approval_id'          =>$second_approval == null ? 0 : $second_approval->user_id,
                        'comment'              =>'this transaction has been approved by system'
                    ];
                    $postSecond =[
                        'request_code'         =>$transaction_code,
                        'item_id'              =>'-',
                        'quantity_request'     =>$request->quantity_request,
                        'location_id'          =>$request->location_id,
                        'des_location_id'      =>$request->location_id,
                        'category_id'          =>$request->category_id,
                        'request_type'         =>$request->transaction_id,
                        'remark'                =>$request->comment,
                        'status'               =>2,
                        'checking'             =>0,
                        'approval_status'      =>0,
                        'user_id'              =>auth()->user()->id,
                        'creator'              =>auth()->user()->id,
                        'approval_id'          =>$second_approval->user_id,
                        'step'                 =>2,
                        'attachment'           =>'',
                    ];

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
    }
}
