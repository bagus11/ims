@extends('layouts.admin')
@section('title', 'Master Sub Category')
@section('content')
<div class="pl-2 pr-2">
    <div class="row">
            <div class="col-md-12">
                <div class="card card-radius">
                    <div class="card-header">
                        <b class="headerTitle">SubCategory List</b>
                      <div class="card-tools">
                        <button class="btn btn-success btn-sm" id="btn_add_subcategory" data-toggle="modal" type="button" data-target="#addSubCategoryModal">
                            <i class="fas fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                        <table class="datatable-bordered nowrap display" id="subcategory_table">
                            <thead>
                                <tr>
                                    <th  style="text-align: center"></th>
                                    <th  style="text-align: center">Status</th>
                                    <th  style="text-align: center">Category</th>
                                    <th  style="text-align: center">Sub Category</th>
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
@include('pettycash.master.subcategory.modal.add-subcategoryModal')
@include('pettycash.master.subcategory.modal.edit-subcategoryModal')
@endsection
@push('custom-js')
@include('pettycash.master.subcategory.master_subcategory-js')
@endpush
