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
                    <p>Current Stock</p>
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
                    <p>Assignment List</p>
                    <hr>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-4 col-xd-4">
            <div class="card card-radius-shadow card-outline">
                {{-- <div class="card-header">
                    Current Stock Product
                </div> --}}
                <div class="card-body">
                    <p>Stock Move</p>
                    <hr>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
        </div>
   </div>
</div>
@endsection
@push('custom-js')
@include('home-js')
@endpush