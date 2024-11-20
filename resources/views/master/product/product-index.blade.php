@extends('layouts.admin')
@section('title', 'Master Product')
@section('content')
<div class="pl-2 pr-2">
    <div class="row">
            <div class="col-md-12">
                <div class="card card-radius">
                    <div class="card-header bg-core">
                     Master Product
                        <div class="card-tools">
                            <div class="btn-group" style="float:right">
                                <button type="button" class="btn btn-sm btn-tool dropdown-toggle" 
                                        style="margin-top:3px" 
                                        data-toggle="dropdown" 
                                        aria-expanded="false">
                                    <i style="color: white" class="fa-solid fa-filter"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" id="filter" role="menu" style="width:250px !important;">
                                    <div class="container">
                                        <!-- Dropdown content -->
                                        @can('get-only_gm-master_product')
                                        <div class="mt-2">
                                            <div class="row">
                                                <div class="col-4 mt-2">
                                                    <p>Office</p>
                                                </div>
                                                <div class="col-8">
                                                    <select name="select_location_filter" id="select_location_filter" class="select2" style="width:100%;margin-top:-10px">
                                                        <option value=""> * - All Office</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="mt-2">
                                            <div class="row">
                                                <div class="col-4 mt-2">
                                                    <p>Category</p>
                                                </div>
                                                <div class="col-8">
                                                    <select class="select2" id="select_category_filter" style="width:100%;margin-top:-10px">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        @endcan
                                        <div class="mt-2 mb-2">
                                            <button class="btn btn-danger btn-block" style="font-size: 10px" id="btn_export_product">
                                                <i class="fa-solid fa-file-pdf"></i> Export to PDF
                                            </button>
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>
                            
                            <button class="btn btn-success btn-sm" id="btn_add_product" data-toggle="modal" type="button" data-target="#addProductModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="datatable-bordered nowrap display" id="product_table">
                            <thead>
                                <tr>
                                    <th  style="text-align: center">No</th>
                                    <th  style="text-align: center">Product Code</th>
                                    <th  style="text-align: center">Location</th>
                                    <th  style="text-align: center">Name</th>
                                    <th  style="text-align: center">Type</th>
                                    <th  style="text-align: center">Category</th>
                                    <th  style="text-align: center">Department</th>
                                    <th  style="text-align: center">Quantity</th>
                                    <th  style="text-align: center">UOM</th>
                                    @can('get-only_staff-master_product')
                                    <th  style="text-align: center">Action</th>
                                    @endcan
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
    </div>
</div>

@include('master.product.modal.add-product')
@include('master.product.modal.history-product')
@include('master.product.modal.edit-product')
@include('master.product.modal.editBuffer-product')
@endsection
@push('custom-js')
  @include('master.product.product-js')
@endpush
