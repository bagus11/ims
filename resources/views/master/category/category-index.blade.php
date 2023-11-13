@extends('layouts.admin')
@section('title', 'Master Category')
@section('content')
<div class="pl-2 pr-2">
    <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b class="headerTitle">Master Category</b>
                        <div class="card-tools">
                            <button class="btn btn-success btn-sm" id="btn_add_category" data-toggle="modal" type="button" data-target="#addCategoryModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="datatable-bordered nowrap display" id="category_table">
                            <thead>
                                <tr>
                                    <th  style="text-align: center">No</th>
                                    <th  style="text-align: center"></th>
                                    <th  style="text-align: center">Status</th>
                                    <th  style="text-align: center">Type</th>
                                    <th  style="text-align: center">Department</th>
                                    <th  style="text-align: center">Name</th>
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
@include('master.category.modal.edit-category')
@include('master.category.modal.add-category')
@endsection
@push('custom-js')
  @include('master.category.category-js')
@endpush
