@extends('layouts.admin')
@section('title', 'Master Petty Cash')
@section('content')
<div class="pl-2 pr-2">
    <div class="row">
            <div class="col-md-12">
                <div class="card card-radius">
                    <div class="card-header bg-core">
                        <b class="headerTitle">List Petty Cash</b>
                      <div class="card-tools">
                        <button class="btn btn-success btn-sm" id="btn_add_pc" data-toggle="modal" type="button" data-target="#addPCModal">
                            <i class="fas fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="pc_table">
                            <thead>
                                <tr>
                                    <th  style="text-align: center"></th>
                                    <th  style="text-align: center">Status</th>
                                    <th  style="text-align: center">No Check</th>
                                    <th  style="text-align: center">Bank</th>
                                    <th  style="text-align: center">Period</th>
                                    <th  style="text-align: center">Total Petty Cash</th>
                                    <th  style="text-align: center">Attachment</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
    </div>
</div>
@include('pettycash.master.master_pettycash.modal.add-pc')
@endsection
@push('custom-js')
@include('pettycash.master.master_pettycash.master_pettycash-js')
@endpush
