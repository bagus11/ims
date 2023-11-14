@extends('layouts.admin')
@section('title', 'Assignment')
@section('content')
<div class="pl-2 pr-2">
    <div class="row">
            <div class="col-md-12">
                <div class="card card-radius">
                    <div class="card-header bg-core">
                        <span style="font-size: 13px">Assignment List</span>
                      <div class="card-tools">
                        <button class="btn btn-primary btn-sm" id="btn_refresh" type="button" >
                            <i class="fas fa-refresh"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                        <table class="datatable-bordered nowrap display" id="assignment_table">
                            <thead>
                                <tr>
                                    <th  style="text-align: center">No</th>
                                    <th  style="text-align: center">Request Code</th>
                                    <th  style="text-align: center">Request Type</th>
                                    <th  style="text-align: center">PIC</th>
                                    <th  style="text-align: center">Location</th>
                                    <th  style="text-align: center">Status</th>
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
@include('transaction.assignment.modal.approve-assignment')
@endsection
@push('custom-js')
@include('transaction.assignment.assignment-js')
@endpush
