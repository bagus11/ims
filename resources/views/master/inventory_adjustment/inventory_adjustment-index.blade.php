@extends('layouts.admin')
@section('title', 'Inventory Adjustment')
@section('content')
<div class="pl-2 pr-2">
    <div class="row">
            <div class="col-md-12">
                <div class="card card-radius">
                    <div class="card-header bg-core">
                     Inventory Adjustment List
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
                                            <button class="btn btn-success btn-block" style="font-size: 10px" id="btn_export_excell">
                                                <i class="fa-solid fa-file-excel"></i> Export to Excell
                                            </button>
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>
                            @can('get-only_gm-master_product')
                            <button class="btn btn-info btn-sm" id="btn_upload_product" data-toggle="modal" type="button" data-target="#uploadProductModal">
                                <i class="fa-solid fa-file-arrow-up"></i>
                            </button>
                            
                            @endcan
                            <button class="btn btn-success btn-sm" id="btn_add_product" data-toggle="modal" type="button" data-target="#addProductModal">
                                <i class="fas fa-plus"></i>
                            </button>
                            
                          
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="datatable-bordered nowrap display" id="inventory_adjustment_table">
                            <thead>
                                <tr>
                                    <th  style="text-align: center">Created At</th>
                                    <th  style="text-align: center">Transaction Code</th>
                                    <th  style="text-align: center">Location</th>
                                    <th  style="text-align: center">Category</th>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
@include('master.inventory_adjustment.modal.detail-adjustment')
@include('master.product.modal.upload-product')
@endsection
@push('custom-js')
  @include('master.inventory_adjustment.inventory_adjustment-js')
@endpush
