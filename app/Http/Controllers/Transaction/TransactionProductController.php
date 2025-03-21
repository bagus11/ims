<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Master\ApprovalModel;
use App\Models\Master\ProductModel;
use App\Models\Transaction\HistoryProduct_model;
use App\Models\Transaction\ItemRequestDetail;
use App\Models\Transaction\ItemRequestModel;
use App\Models\Transaction\PurchaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Mpdf\Mpdf as PDF;
class TransactionProductController extends Controller
{
    function index() {
        return view('transaction.history_product.history_product-index');
    }
    function getHistoryProduct(Request $request) {
        ini_set('max_execution_time','60000');
        // $totalData      = HistoryProduct_model::with([
        //     'itemRelation',
        //     'desLocationRelation',
        //     'transactionRelation.userRelation',
        //     'locationRelation',
        //     'transactionRelation',
        // ])->count();
        // $limit          = $request->length;
        // $start          = $request->start;
        // $query      = HistoryProduct_model::with([
        //                 'itemRelation',
        //                 'desLocationRelation',
        //                 'transactionRelation.userRelation',
        //                 'locationRelation',
        //                 'transactionRelation',
        //             ])->orderBy('id', 'desc')->offset($start)->limit($limit);
        // if(is_null($request->search['value'])){
            
        // // dd($query->get());
        // }else{
        //     $search     = $request->search['value'];
        //     $query      =HistoryProduct_model::with([
        //                             'itemRelation',
        //                             'desLocationRelation',
        //                             'transactionRelation.userRelation:name',
        //                             'locationRelation:name',
        //                             'transactionRelation:name',
        //                         ])
        //                         ->whereHas('itemRelation', function($query) use($search){
        //                             return $query->where('name','like','%'.$search.'%');
        //                         })
        //                         ->whereHas('transactionRelation.userRelation', function($query) use($search){
        //                             return $query->where('name','like','%'.$search.'%');
        //                         })
        //                         ->orderBy('id','desc')
        //                         ->offset($start)
        //                         ->limit($limit);
        //     $totalData  = HistoryProduct_model::with([
        //                             'itemRelation',
        //                             'desLocationRelation',
        //                             'transactionRelation.userRelation',
        //                             'locationRelation',
        //                             'transactionRelation',
        //                         ])
        //                         ->whereHas('itemRelation', function($query) use($search){
        //                             return $query->where('name','like','%'.$search.'%');
        //                         })
        //                         ->whereHas('transactionRelation.userRelation', function($query) use($search){
        //                             return $query->where('name','like','%'.$search.'%');
        //                         })
        //                         ->orderBy('id', 'desc')
        //                         ->count();
        // }
        // $data=[];
        // if(count($query->get()) > 0 ){
        //     foreach($query->get() as $row){
        //         $datetimeExplode = explode(' ',  $row['created_at']);

        //         $arrData =[
        //             'created_at'            =>$datetimeExplode[0].' '.$datetimeExplode[1],
        //             'request_code'          => $row['request_code'],
        //             'item_name'             => $row['itemRelation']['name'],
        //             'location_name'         => $row['locationRelation']['name'],
        //             'des_location_name'     => $row['desLocationRelation']['name'],
        //             'quantity'              => $row['quantity'],
        //             'quantity_request'      => $row['quantity_request'],
        //             'quantity_result'       => $row['quantity_result'],
        //             'pcs'                   => 'pcs',
        //             'pic'                   => $row['transactionRelation']['userRelation']['name'],
                  
        //         ];
        //         array_push($data,$arrData);
        //     }
        // }
        // return response()->json([
        //     'draw'              => intval($request->draw),
        //     'recordsTotal'      => intval($totalData),
        //     'recordsFiltered'   => intval($totalData),
        //     'data'              => $data
        // ]);
            $productCode = '';
            if ($request->productFilter) {
                $productFilter = ProductModel::find($request->productFilter);
                if ($productFilter) {
                    $productCode = $productFilter->product_code;
                }
            }
            $user = auth()->user();
            $query = HistoryProduct_model::with([
                'itemRelation',
                'desLocationRelation',
                'transactionRelation.userRelation',
                'locationRelation',
                'transactionRelation',
            ]);
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->from, $request->to]);
            $query->where('source_location', 'like', '%' . $request->officeFilter . '%');
            if($productCode !='') $query->where('product_code', $productCode);
            $query->whereHas('transactionRelation', function($query) use ($request) {
                $query->where('user_id', 'like', '%' . $request->reqFilter . '%');
            });
            if ($user->hasPermissionTo('get-only_gm-master_product')) {
                $query->whereHas('itemRelation', function($query) {
                    $query->where('department_id', 'like', '%%');
                });
            } else {
                // dd('test');
                $query->whereHas('itemRelation', function($query) use ($user) {
                    $query->where('department_id', $user->departement);
                })->whereHas('itemRelation', function($query) use($user) {
                    $query->where('location_id', $user->kode_kantor);
                });
            }
            $data = $query->orderBy('id', 'desc')->get();
            return response()->json([
                'data' => $data
            ]);
    }
    function getHistoryProductDashboard(Request $request) {
        $user = auth()->user();
        $query = HistoryProduct_model::with([
            'itemRelation',
            'desLocationRelation',
            'transactionRelation.userRelation',
            'locationRelation',
            'transactionRelation',
        ]);
        $query->whereBetween(DB::raw('DATE(created_at)'), [$request->from, $request->to]);
        if ($user->hasPermissionTo('get-only_gm-master_product')) {
            $query->whereHas('itemRelation', function($query) {
                $query->where('department_id', 'like', '%%');
            });
        } else {
            $query->whereHas('itemRelation', function($query) use ($user) {
                $query->where('department_id', $user->departement);
            });
        }
        $query->orderBy('id', 'desc');
        $data = $query->get();
        return response()->json([
            'data' => $data
        ]);
    }
    function getPICReq(Request $request) {
       $data = ItemRequestModel::with('userRelation')->where('status', 6)
                                ->groupBy('user_id')
                                ->orderBy('created_at','desc')
                                ->get();
        return response()->json([
            'data'      => $data,
        ]);
    }
    function print_stock_move($from,$to,$productFilter,$officeFilter,$reqFilter) {
        ini_set('memory_limit', '900000M');
        ini_set('pcre.backtrack_limit', '5000000');
        ini_set('pcre.recursion_limit', '5000000');        
        set_time_limit(60000);
        $productCode = '';
            if($productFilter != '*'){
                $productFilter = ProductModel::find($productFilter);
                $productCode = $productFilter->product_code;
            }
            $officeString = $officeFilter == '*' ? '' : $officeFilter;
            $reqString  = $reqFilter =='*' ?'' : $reqFilter;
            $data_stok = HistoryProduct_model::with([
                'itemRelation',
                'desLocationRelation',
                'transactionRelation.userRelation',
                'locationRelation',
                'transactionRelation',
            ])
            ->whereBetween(DB::raw('DATE(created_at)'), [$from, $to])
            ->where('source_location','like','%'.$officeString.'%')
            ->where('product_code','like','%'.$productCode.'%')
            ->whereHas('transactionRelation',function($query) use($reqString){
                $query->where('user_id', 'like', '%'.$reqString .'%');
            })
            ->orderBy('created_at','desc')
            ->get();
            // dd($data_stok);
            $data =[
                'data'=>$data_stok,
                'from'=>$from,
                'to'=>$to,
            ];
            $cetak              = view('transaction.history_product.report_stock',$data);
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
    function print_ir($request_code) {
        $request_code =  str_replace("&*.","/",$request_code);
        
        $detail = ItemRequestModel::with([
            'userRelation',
            'itemRelation',
            'locationRelation',
            'desLocationRelation',
            'approvalRelation',
        ])->where('request_code',$request_code)->first();
        // $countApproval = ApprovalModel::where('location_id',$request->des)->count();
        $log = ItemRequestDetail::with([
            'userRelation',
            'creatorRelation',
        ])->where('request_code',$request_code)->get();
        $data =[
            'log'=>$log,
            'detail'=>$detail,
            'request_code'=>$request_code,
        ];
        // dd(auth()->user()->roles->pluck('name')[0]);
        if(auth()->user()->roles->pluck('name')[0] =='User'){
            $cetak              = view('transaction.ir.report.report_ir_user',$data);
        }else{
            $cetak              = view('transaction.ir.report.report_ir',$data);
        }
        $imageLogo          = '<img src="'.public_path('icon.png').'" width="70px" style="float: right;"/>';
        $header             = '';
        $header             .= '<table width="100%">
                                        <tr>
                                        <td style="padding-left:10px;">
                                        <span style="font-size: 6px; font-weight: bold;margin-top:-10px"> '.$imageLogo.'</span>
                                        <br>
                                        <span style="font-size:8px;">Synergy Building #08-08</span> 
                                        <br>
                                        <span style="font-size:8px;">Jl. Jalur Sutera Barat 17 Alam Sutera, Serpong Tangerang 15143 - Indonesia</span>
                                        <br>
                                        <span style="font-size:8px;">Tangerang 15143 - Indonesia +62 21 304 38808</span>
                                    </td>
                                        </tr>
                                        
                                    </table>
                                ';
        
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
                'P', // L - landscape, P - portrait 
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
            $mpdf->Output('Report Wo'.'('.date('Y-m-d').').pdf', 'I');
            
    }
    function print_pr($request_code) {
        $request_code =  str_replace("&*.","/",$request_code);
        
        $detail = ItemRequestModel::with([
            'userRelation',
            'itemRelation',
            'locationRelation',
            'desLocationRelation',
            'approvalRelation',
        ])->where('request_code',$request_code)->first();
        // $countApproval = ApprovalModel::where('location_id',$request->des)->count();
        $log = ItemRequestDetail::with([
            'userRelation',
            'creatorRelation',
            
        ])->where('request_code',$request_code)->get();
        $logProduct =PurchaseModel::with(
            [
                'itemRelation',
                'transactionRelation'
            ]
        )->where('request_code', $request_code)->get();
        $data =[
            'log'=>$log,
            'detail'=>$detail,
            'request_code'=>$request_code,
            'logProduct'=>$logProduct,
        ];
        $cetak              = view('transaction.pr.report.report_pr',$data);
        $imageLogo          = '<img src="'.public_path('icon.png').'" width="70px" style="float: right;"/>';
        $header             = '';
        $header             .= '<table width="100%">
                                    <tr>
                                    <td style="padding-left:10px;">
                                    <span style="font-size: 6px; font-weight: bold;margin-top:-10px"> '.$imageLogo.'</span>
                                    <br>
                                    <span style="font-size:8px;">Synergy Building #08-08</span> 
                                    <br>
                                    <span style="font-size:8px;">Jl. Jalur Sutera Barat 17 Alam Sutera, Serpong Tangerang 15143 - Indonesia</span>
                                    <br>
                                    <span style="font-size:8px;">Tangerang 15143 - Indonesia +62 21 304 38808</span>
                                </td>
                                    </tr>
                                    
                                </table>
                               ';
        
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
                'P', // L - landscape, P - portrait 
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
            $mpdf->Output('Report Wo'.'('.date('Y-m-d').').pdf', 'I');
            
    }
}
