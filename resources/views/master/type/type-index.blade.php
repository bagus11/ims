@extends('layouts.admin')
@section('title', 'Master Type')
@section('content')
<div class="pl-2 pr-2">
    <div class="row">
            <div class="col-md-12">
                <div class="card card-radius">
                    <div class="card-header">
                        <b class="headerTitle">Master Type</b>
                        <div class="card-tools">
                            <button class="btn btn-success btn-sm" id="btn_add_type" data-toggle="modal" type="button" data-target="#addTypeModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="datatable-bordered nowrap display" id="type_table">
                            <thead>
                                <tr>
                                    <th  style="text-align: center">No</th>
                                    <th  style="text-align: center"></th>
                                    <th  style="text-align: center">Status</th>
                                    <th  style="text-align: center">Initial</th>
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
@include('master.type.modal.add-type')
@include('master.type.modal.edit-type')
@endsection
@push('custom-js')
  @include('master.type.type-js')
@endpush
