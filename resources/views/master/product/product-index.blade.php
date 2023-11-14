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
@include('master.product.modal.edit-product')
@include('master.product.modal.editBuffer-product')
@endsection
@push('custom-js')
  @include('master.product.product-js')
@endpush
