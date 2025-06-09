@extends('layouts.admin')
@section('title', 'Home')
@section('content')
<div class="pr-2 pl-2">
   <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-4 col-xd-4">
            <div class="card card-radius-shadow card-outline">
                {{-- <div class="card-header">
                    Current Stock Product
                </div> --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <h5 style="font-weight: bold">Current Stock</h5>
                        </div>
                        <div class="col-3" style="text-align: center">
                            <i style="color:#6B92A4 " class="fa-solid fa-box-archive fa-2xl"></i>
                        </div>
                    </div>
                    <hr>
                    @can('get-only_gm-master_product')
                    <div class="row p-0">
                        <div class="col-3 mt-2">
                            <p>Location</p>
                        </div>
                        <div class="col-9">
                            <select name="select_location_filter" class="select2" id="select_location_filter" class="select2"></select>
                        </div>
                    </div>
                    @endcan
                    <table class="table" id="product_table">
                        <thead>
                            <tr>
                                <th  style="text-align: center">Location</th>
                                <th  style="text-align: center">Product Name</th>
                                <th  style="text-align: center">Quantity</th>
                                <th  style="text-align: center">UOM</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-xd-4">
            <div class="card card-radius-shadow card-outline">
                {{-- <div class="card-header">
                    Current Stock Product
                </div> --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <h5 style="font-weight: bold">Assignment</h5>
                        </div>
                        <div class="col-3" style="text-align: center">
                            <i style="color:#6B92A4 " class="fa-solid fa-hand fa-2xl"></i>
                        </div>
                    </div>
                    <hr>
                    <table class="table" id="assignment_table">
                        <thead>
                            <tr>
                                <th  style="text-align: center">Created At</th>
                                <th  style="text-align: center">Request Code</th>
                                <th  style="text-align: center">PIC</th>
                                <th  style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-xd-4">
            <div class="card card-radius-shadow card-outline">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <h5 style="font-weight: bold">Finalize</h5>
                        </div>
                        <div class="col-3" style="text-align: center">
                            <i style="color:#6B92A4 " class="fa-solid fa-star fa-2xl"></i>
                        </div>
                    </div>
                    <hr>
                    <table class="table" id="finalize_table">
                        <thead>
                            <tr>
                                <th  style="text-align: center">Created At</th>
                                <th  style="text-align: center">Request Code</th>
                                <th  style="text-align: center">PIC</th>
                                <th  style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-xd-12">
            <div class="card card-radius-shadow card-outline">
                {{-- <div class="card-header">
                    Current Stock Product
                </div> --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <h5 style="font-weight: bold">Stock Move</h5>
                        </div>
                        <div class="col-3" style="text-align: center">
                            <i style="color:#6B92A4 " class="fa-solid fa-paper-plane fa-2xl"></i>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <input type="date" id="from" class="form-control" value="{{date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) )}}">
                        </div>
                        <div class="col">
                            <input type="date" class="form-control" id="to" value="{{date('Y-m-d')}}">
                        </div>
                    </div>
                    <table class="table" id="stock_move_table" style="width: 150px !important; position: sticky;">
                        <thead>
                            <tr>
                                <th  style="text-align: center">Created At</th>
                                <th  style="text-align: center">Request Code</th>
                                <th  style="text-align: center">Item Name</th>
                                <th  style="text-align: center">Quantity</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>
       
   </div>
</div>
@include('modal.low_stock')
@include('transaction.multiple_request.modal.detail-request')
@include('transaction.multiple_request.modal.update-request')
@include('modal.approve-assignment')
@endsection
@push('custom-js')
@include('home-js')
@endpush