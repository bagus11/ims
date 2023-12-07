@extends('layouts.admin')
@section('title', 'Master Category')
@section('content')
<div class="pl-2 pr-2">
    <div class="row">
            <div class="col-md-12">
                <div class="card card-radius">
                    <div class="card-header bg-core">
                        <b class="headerTitle">List Category</b>
                      <div class="card-tools">
                        <button class="btn btn-success btn-sm" id="btn_add_category_pc" data-toggle="modal" type="button" data-target="#addCategoryModal">
                            <i class="fas fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="category_pc_table">
                            <thead>
                                <tr>
                                    <th  style="text-align: center"></th>
                                    <th  style="text-align: center">Status</th>
                                    <th  style="text-align: center">Name</th>
                                    <th  style="text-align: center">Min Transaction</th>
                                    <th  style="text-align: center">Max Transaction</th>
                                    <th  style="text-align: center">Duration</th>
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
@include('pettycash.master.master_category.modal.add-category_pc')
@include('pettycash.master.master_category.modal.edit-category_pc')
@endsection
@push('custom-js')
@include('pettycash.master.master_category.master_category_pc-js')
@endpush
