@extends('layouts.admin')
@section('title', 'Stock Move')
@section('content')
<div class="pl-2 pr-2">
    <div class="row">
            <div class="col-md-12">
                <div class="card card-radius">
                    <div class="card-header bg-core">
                        Stock Move
                        <div class="card-tools">
                            <div class="btn-group" style="float:right">
                                <button type="button" class="btn btn-sm btn-tool dropdown-toggle" style="margin-top:3px" data-toggle="dropdown">
                                    <i style="color: white" class="fa-solid fa-filter"></i>
                                </button>
                           
                                <div class="dropdown-menu dropdown-menu-right" id="filter" role="menu" style="width:250px !important;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-6 mt-2">
                                               <p>From</p>
                                                <input type="date" id="from" class="form-control" value="{{date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) )}}">
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <p>To</p>
                                                <input type="date" class="form-control" id="to" value="{{date('Y-m-d')}}">
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <div class="row">
                                                <div class="col-3 mt-2">
                                                    <p>Office</p>
                                                </div>
                                                <div class="col-9">
                                                    <select name="officeFilter" id="officeFilter" class="select2" style="width:100%;margin-top:-10px">
                                                        <option value=""> * - All Office</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <div class="row">
                                                <div class="col-3 mt-2">
                                                    <p>Item </p>
                                                </div>
                                                <div class="col-9">
                                                    <select class="select2" id="productFilter" style="width:100%;margin-top:-10px">
                                                        <option value="">Choose Location First</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <div class="row">
                                                <div class="col-3 mt-2">
                                                    <p>PIC</p>
                                                </div>
                                                <div class="col-9">
                                                    <select class="select2" id="reqFilter" style="width:100%;margin-top:-10px">
                                                        <option value="">Choose Location First</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2 mb-2">
                                            <button style="color: white;font-size:9px" class="btn btn-info btn-block"style="font-size: 10px"  id="btn_filter_stock">
                                                <i class="fa-solid fa-filter"></i> Filter
                                            </button>
                                        </div>
                                        <div class="mt-2 mb-2">
                                            <button class="btn btn-danger btn-block" style="font-size: 10px" id="btn_report_stock">
                                                <i class="fa-solid fa-file-pdf"></i> Export to PDF
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="datatable datatable-bordered" id="product_table" style="font-size:9px">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align:center;">Created At</th>
                                    <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">Request Code</th>
                                    <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">Item Name</th>
                                    <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">Location</th>
                                    <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">Destination Location</th>
                                    <th colspan="3" style="text-align:center; padding-left:10px;padding-right:10px">Quantity</th>
                                    <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">UOM</th>
                                    <th rowspan="2" style="text-align:center; padding-left:10px;padding-right:10px">PIC</th>
                                  
                                </tr>
                                <tr>
                                    <th>Before</th>
                                    <th>Request</th>
                                    <th>Current</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
    </div>
</div>
@endsection

@push('custom-js')
@include('transaction.history_product.history_product-js')
@endpush
