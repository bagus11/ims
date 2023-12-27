@extends('layouts.admin')
@section('title', 'PettyCash Request')
@section('content')
<div class="pl-2 pr-2">
    <div class="row">
            <div class="col-md-12">
                <div class="card card-radius">
                    <div class="card-header bg-core">
                        <b class="headerTitle">PettyCash List</b>
                      <div class="card-tools">
                        <button class="btn btn-success btn-sm" id="btn_add_pr" data-toggle="modal" type="button" data-target="#addPettycashRequst">
                            <i class="fas fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                        <table class="datatable-bordered nowrap display" id="pettycash_request_table">
                            <thead>
                                <tr>
                                    <th  style="text-align: center">PC Code</th>
                                    <th  style="text-align: center">Category</th>
                                    <th  style="text-align: center">Amount</th>
                                    <th  style="text-align: center">Status</th>
                                    <th  style="text-align: center">PIC</th>
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

@include('pettycash.transaction.pettycash_request.modal.add-pettycash_request')
@endsection
@push('custom-js')
@include('pettycash.transaction.pettycash_request.pettycash_request-js')
@endpush
