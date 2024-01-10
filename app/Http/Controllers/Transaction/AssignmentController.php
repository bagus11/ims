<?php

namespace App\Http\Controllers\Transaction;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Models\Master\ApprovalModel;
use App\Models\Master\ProductModel;
use App\Models\MasterLocation;
use App\Models\Transaction\HistoryProduct_model;
use App\Models\Transaction\ItemRequestDetail;
use App\Models\Transaction\ItemRequestModel;
use App\Models\Transaction\PurchaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    function index() {
        return view('transaction.assignment.assignment-index');
    }
    function getAssignment(Request $request) {
        $data = ItemRequestModel::with([
            'userRelation',
            'itemRelation',
            'locationRelation',
        ])->whereIn('status',[1,2])
        ->where('approval_id',auth()->user()->id)->get();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    function updateAssignment(Request $request, UpdateAssignmentRequest $updateAssignmentRequest) {
        // try {
            $updateAssignmentRequest->validated();
            $dataOld            = ItemRequestDetail::where('request_code',$request->id)->orderBy('id','desc')->first();
            // setup Type
                if($dataOld->request_type == 4){
                    $purchaseModel      =  PurchaseModel::where('request_code', $request->id)->first();
                    $productCategory    = ProductModel::where('product_code',$purchaseModel->product_code)->first();
                }else{
                    $productCategory    = ProductModel::where('product_code',$dataOld->item_id)->first();
                }
            // setup Type
            $stepApproval       = $dataOld->step == 1 ? $dataOld->step + 1 : $dataOld->step + 1;
            $NextApporval       = ApprovalModel::where([
                'location_id' => $dataOld->location_id,
                'category_id' => $productCategory->category_id,
            ])->where('step', $stepApproval)->first();
            $countApproval  =ApprovalModel::where([
                'location_id' => $dataOld->location_id,
                'category_id' => $productCategory->category_id,
            ])->orderBy('id','desc')->count();
            $status         = '';
            $approvalId =$NextApporval ? $NextApporval->user_id:0;
            $approval_status =$request->approval_id;
            $step ='';
            $updateProduct ='';
            $finalItem ='';
            $updatePost =[];
            $post_array=[];
            $purchaseItem ='';
            if($request->approval_id == 7){
                $status =7;
                $step = $dataOld->step + 1;
            }else{
                if($dataOld->status == 1 && $request->approval_id == 1){
                    if($dataOld->step == $countApproval){
                        $status = 3;
                        $approvalId = 0;
                        $approval_status = 0;
                    }else{
                        $status = 2;
                    }
                }else if($dataOld->status == 2 && $request->approval_id == 1){
                    if($dataOld->step == $countApproval){
                    
                        $status = 3;
                        $countApprovalFirst  =ApprovalModel::where([
                            'location_id' => $dataOld->location_id,
                            'category_id' => $productCategory->category_id,
                        ])->orderBy('id','asc')->first();
                        $approvalId = $countApprovalFirst->user_id;
                        $approval_status = 0;
                    }else{
                        $status = 2;
                    }
                }else if($dataOld->status == 4 && $dataOld->checking == 1){
                    if($dataOld->request_type != 4){
                        $updateProduct = ProductModel::where('product_code', $dataOld->item_id)->first();   
                        $finalItem = $dataOld->request_type == 1 || $dataOld->request_type == 3 ?  $updateProduct->quantity - $dataOld->quantity_request : $updateProduct->quantity + $dataOld->quantity_request;
                        $status = $request->approval_id == 1 ? 6 : 7;                  
                    }else{
                        $status = $request->approval_id == 1 ? 6 : 7;                  
                    }
                }

                if($status == 2 || $status == 1){
                    $step = $dataOld->step + 1;
                }else{
                    $step = $dataOld->step;
                }
            }
           
            $statusLog = $status == 3? $dataOld->status : $status ;

            $post_log =[
                'request_code'      => $dataOld->request_code,
                'item_id'           => $dataOld->item_id,
                'quantity_request'  => $dataOld->quantity_request,
                'location_id'       => $dataOld->location_id,
                'request_type'      => $dataOld->request_type,
                'status'            => $statusLog,
                'checking'          => $request->approval_id == 1 && $dataOld->status == 4  ? 1 : $dataOld->checking,
                'creator'           => auth()->user()->id,
                'user_id'           => $dataOld->user_id,
                'approval_status'   => $request->approval_id,
                'step'              => $step,
                'des_location_id'   => $dataOld->des_location_id,
                'approval_id'       => $approvalId,
                'comment'           => $request->approve_comment,
            ];
            $post =[
                'creator'           =>auth()->user()->id,
                'status'            => $status,
                'checking'          => $request->approval_id == 1 && $dataOld->status == 4  ? 2 : $dataOld->checking,
                'step'              => $step,
                'approval_status'   => $approval_status,
                'approval_id'       => $approvalId,

            ];
            $postLogProduct=[];
            if($dataOld->status == 4 && $dataOld->request_type != 4 ){
                $postLogProduct =[
                    'product_code' =>$dataOld->item_id,
                    'request_code' =>$dataOld->request_code,
                    'source_location' =>$dataOld->location_id,
                    'destination_location' =>$dataOld->des_location_id,
                    'quantity_request' =>$dataOld->quantity_request,
                    'quantity' =>$updateProduct->quantity,
                    'quantity_result' =>$finalItem,
                ];
            }
            
            DB::transaction(function() use($post,$post_log,$request,$postLogProduct,$dataOld, $updateProduct, $updatePost,$post_array,$finalItem) {
                if($dataOld->status == 4 && $request->approval_id == 1){
                    if($dataOld->request_type == 4){
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
                        HistoryProduct_model::insert($post_array);
                    }else{
                        HistoryProduct_model::create($postLogProduct);
                        $updatePost =[
                            'quantity'=>$finalItem
                        ];
                        $updateProduct->update($updatePost);
                    }
                }
                ItemRequestModel::where('request_code',$request->id)->update($post);
                ItemRequestDetail::create($post_log);
                if($request->approval_id != 1){
                   $productCode = ProductModel::where('product_code',$dataOld->item_id)->first();
                   ProductModel::where('product_code',$dataOld->item_id)->update([
                    'quantity_buffer' => $productCode->quantity_buffer - $dataOld->quantity_request
                   ]);
                }
            });
            return ResponseFormatter::success(   
                $updateAssignmentRequest,                              
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
