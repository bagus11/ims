<?php

namespace App\Http\Controllers\Master;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\updateBufferRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Master\BufferLog;
use App\Models\Master\CategoryModel;
use App\Models\Master\ProductModel;
use App\Models\Master\TypeModel;
use App\Models\Transaction\HistoryProduct_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Mpdf\Mpdf as PDF;

class MasterProductController extends Controller
{
    function index(){
        return view('master.product.product-index');
    }
    function getProduct() {
        // dd(auth()->user()->departement);
    
        if(auth()->user()->hasPermissionTo('get-only_gm-master_product')){
            $data = ProductModel::with(['typeRelation','categoryRelation','locationRelation','departmentRelation'])->get();
        }else{
           
            $data = ProductModel::with(['typeRelation','categoryRelation','locationRelation','departmentRelation'])
                                ->where('department_id',auth()->user()->departement)
                                ->where('location_id',auth()->user()->kode_kantor)
                                ->get();
        }
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

    function trackRequestHistory(Request $request){
        $user = auth()->user();
        $query = HistoryProduct_model::with([
            'itemRelation',
            'desLocationRelation',
            'transactionRelation.userRelation',
            'locationRelation',
            'transactionRelation',
        ]);
        $product = ProductModel::find($request->product_id);
        
        $query->whereBetween(DB::raw('DATE(created_at)'), [$request->from, $request->to]);
        // $query->where('source_location', $user->kode_kantor);
        $query->where('product_code', $product->product_code);
        $query->whereHas('itemRelation', function($query) use ($user) {
            $query->where('location_id', $user->kode_kantor);
        })->whereHas('transactionRelation',function($query) use($request){
            $query->where('request_type',$request->request_type);
        });
        
        $data = $query->orderBy('id', 'desc')->get();
        return response()->json([
            'data' => $data
        ]);
    }
    function exportMasterProductReport($location, $category){
        if(auth()->user()->hasPermissionTo('get-only_gm-master_product')){
            $data_report = ProductModel::with(['typeRelation','categoryRelation','locationRelation','departmentRelation'])->get();
        }else{
            $category = CategoryModel::where('department_id', auth()->user()->departement)->first();
            $data_report = ProductModel::with(['typeRelation','categoryRelation','locationRelation','departmentRelation'])
                                ->where('location_id',auth()->user()->kode_kantor)
                                ->where('category_id',$category->id)
                                ->get();
        }
       
        $data =[
            'data' => $data_report
        ];
        $cetak              = view('master.product.product_report', $data);
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
                                <table width="100%" style="font-size: 8px;margin-top:-5px">
                                <tr>
                                <td width="90%" align="left"><b>Disclaimer</b><br>this document is strictly private, confidential and personal to recipients and should not be copied, distributed or reproduced in whole or in part, not passed to any third party.</td>
                                        <td width="10%" style="text-align: right;"> {PAGENO}</td>
                                    </tr>
                                </table>';

        
            $mpdf           = new PDF();
            $mpdf->SetHTMLHeader($header);
            $mpdf->SetHTMLFooter($footer);
            $mpdf->AddPage(
                'P', // L - landscape, P - portrait 
                '',
                '',
                '',
                '',
                2, // margin_left
                2, // margin right
                18, // margin top
                18, // margin bottom
                2, // margin header
                0
            ); // margin footer
            $mpdf->WriteHTML($cetak);
            // Output a PDF file directly to the browser
            ob_clean();
            $mpdf->Output('Report Stock'.'('.date('Y-m-d').').pdf', 'I');
    }
}
