@extends('layouts.admin')
@section('title', 'Approver')
@section('content')
<div class="pl-2 pr-2">
    <div class="row">
            <div class="col-md-12">
                <div class="card card-radius">
                    <div class="card-header">
                        <b class="headerTitle">Approver By Location</b>
                      <div class="card-tools">
                        <button class="btn btn-success btn-sm" id="btn_add_approver" data-toggle="modal" type="button" data-target="#addApprover">
                            <i class="fas fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                        <table class="datatable-bordered nowrap display" id="approver_table">
                            <thead>
                                <tr>
                                    <th  style="text-align: center">No</th>
                                    <th  style="text-align: center">Approval ID</th>
                                    <th  style="text-align: center">Department</th>
                                    <th  style="text-align: center">Location</th>
                                    <th  style="text-align: center">Step Approval</th>
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
@include('pettycash.master.master_approver.modal.add-approver_pc')
@include('pettycash.master.master_approver.modal.edit-approver_pc')
@include('pettycash.master.master_approver.modal.step-approver_pc')
@endsection
@push('custom-js')
@include('pettycash.master.master_approver.master_approver_pc-js')
@endpush
