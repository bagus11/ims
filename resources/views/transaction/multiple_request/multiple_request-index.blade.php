@extends('layouts.admin')
@section('title', 'Item Request')
@section('content')
<div class="pl-2 pr-2">
    <div class="row">
            <div class="col-md-12">
                <div class="card card-radius">
                    <div class="card-header bg-core ">
                       <span style="font-size: 13px">Transaction List</span>
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
                                                <input type="date" style="font-size: 10px !important" id="from" class="form-control" value="{{date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) )}}">
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <p>To</p>
                                                <input type="date" style="font-size: 10px !important" class="form-control" id="to" value="{{date('Y-m-d')}}">
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <div class="row">
                                                <div class="col-3 mt-2">
                                                    <p>Office</p>
                                                </div>
                                                <div class="col-9">
                                                    <select name="location_filter" id="location_filter" class="select2" style="width:100%;margin-top:-10px">
                                                        <option value=""> * - All Office</option>
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
                                            <button style="color: white;font-size:9px" class="btn btn-info btn-block"style="font-size: 10px"  id="btn_filter">
                                                <i class="fa-solid fa-filter"></i> Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <button class="btn btn-primary btn-sm" id="btn_refresh" type="button" >
                            <i class="fas fa-refresh"></i>
                        </button>
                        <button class="btn btn-success btn-sm" id="btn_add_request" data-toggle="modal" type="button" data-target="#addRequestModal">
                            <i class="fas fa-plus"></i>
                        </button>
                       
                      </div>
                    </div>
                    <div class="card-body">
                        <table class="datatable-bordered nowrap display" id="request_table">
                            <thead>
                                <tr>
                                    <th  style="text-align: center">Created at</th>
                                    <th  style="text-align: center">Request Code</th>
                                    <th  style="text-align: center">PIC</th>
                                    <th  style="text-align: center">Location</th>
                                    <th  style="text-align: center">Status</th>
                                    <th  style="text-align: center">Action</th>
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
@include('transaction.multiple_request.modal.add-request')
@include('transaction.multiple_request.modal.detail-request')
@include('transaction.multiple_request.modal.update-request')
@push('custom-js')
@include('transaction.multiple_request.multiple_request-js')
@endpush
