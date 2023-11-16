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
                    <table class="table" id="product_table">
                        <thead>
                            <tr>
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
@endsection
@push('custom-js')
@include('home-js')
@endpush