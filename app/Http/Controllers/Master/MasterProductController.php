<?php

namespace App\Http\Controllers\Master;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\updateBufferRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Master\BufferLog;
use App\Models\Master\ProductModel;
use App\Models\Master\TypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterProductController extends Controller
{
    function index(){
        return view('master.product.product-index');
    }
    function getProduct() {
        $data = ProductModel::with(['typeRelation','categoryRelation','locationRelation','departmentRelation'])->get();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    function getActiveProduct(Request $request) {
        $data = ProductModel::with(['typeRelation','categoryRelation','locationRelation'])
                            ->where('location_id',$request->id)
                            ->where('category_id','like','%'.$request->category_id.'%')
                            ->get();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    function addProduct(Request $request, StoreProductRequest $storeProductRequest) {
        // try {
            $storeProductRequest->validated();
            $getLastTicket = ProductModel::where([
                'category_id'   =>$request->category_id,
                'location_id'   =>$request->location_id
            ])->orderBy('id','desc')->first();
            $initialType = TypeModel::find($request->type_id);
            $ticket='';
            if($getLastTicket == null){
              $ticket = $initialType->initial.'/'.str_pad($request->location_id, 2, '0', STR_PAD_LEFT).'/'.str_pad($request->category_id, 3, '0', STR_PAD_LEFT).'/1';
             
            }else{
                $explodeLastTicket      = explode('/',$getLastTicket->product_code);
                $convertIntLastTikcket  = (int)$explodeLastTicket[3];
                $ticket = $initialType->initial.'/'.str_pad($request->location_id, 2, '0', STR_PAD_LEFT).'/'.str_pad($request->category_id, 3, '0', STR_PAD_LEFT).'/'.$convertIntLastTikcket + 1;
            }
            $post =[
                'product_code'      => $ticket,
                'name'              => $request->name,
                'category_id'       => $request->category_id,
                'department_id'     => $request->department_id,
                'type_id'           => $request->type_id,
                'location_id'       => $request->location_id,
                'uom'               => $request->uom_id,
                'quantity'          => $request->quantity,
                'min_quantity'      =>0,
                'quantity_buffer'   =>0,
                'last_price'        =>0
            ];
            
            ProductModel::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'Product successfully updated'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Product failed to update',
        //         500
        //     );
        // }
    }
    function detailProduct(Request $request) {
        $detail = ProductModel::with(['typeRelation','categoryRelation','locationRelation'])->where('id',$request->id)->first();
       
        return response()->json([
            'detail'=>$detail,  
          
        ]);  
    }
    function logBufferProduct(Request $request) {
        $detail = ProductModel::with(['typeRelation','categoryRelation','locationRelation'])->where('product_code',$request->product_code)->first();
        $data   = BufferLog::with(['userRelation','productRelation'])->where('product_code',$request->product_code)->orderBy('created_at','desc')->get();
        return response()->json([
            'detail'=>$detail,  
            'data'=>$data,  
        ]);  
    }
    function updateProduct(Request $request, UpdateProductRequest $updateProductRequest) {
        try {
            $updateProductRequest->validated();
           
            $post =[
                'name'              => $request->name_edit,
                'category_id'       => $request->category_id_edit,
                'type_id'           => $request->type_id_edit,
                'location_id'       => $request->location_id_edit,
            ];
            
            ProductModel::find($request->id)->update($post);
            return ResponseFormatter::success(   
                $post,                              
                'Product successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Product failed to update',
                500
            );
        }
    }
    function updateBuffer(Request $request, updateBufferRequest $updateBufferRequest) {
        try {
            $updateBufferRequest->validated();
           
            $post =[
                'min_quantity'              => $request->buffer_min,
                'max_quantity'              => $request->buffer_max,
            ];
            $dataOld = ProductModel::where('product_code',$request->product_code)->first();
            $postBuffer =[
                    'product_code'      =>$request->product_code,
                    'buffer_max_before' =>$dataOld->max_quantity,
                    'buffer_min_before' =>$dataOld->min_quantity,
                    'buffer_max_after'  =>$request->buffer_max,
                    'buffer_min_after'  =>$request->buffer_min,
                    'uom'               =>$dataOld->uom,
                    'user_id'           =>auth()->user()->id
            ];
         
            DB::transaction(function() use($post,$postBuffer,$request) {
                ProductModel::where('product_code',$request->product_code)->update($post);
                BufferLog ::create($postBuffer);
            });
            $data   = BufferLog::with(['userRelation','productRelation'])->where('product_code',$request->product_code)->orderBy('created_at','desc')->get();
            return ResponseFormatter::success(   
                $data,                              
                'Product successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Product failed to update',
                500
            );
        }
    }
}
