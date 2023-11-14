@extends('layouts.admin')
@section('title', 'Item Request')
@section('content')
<div class="pl-2 pr-2">
    <div class="row">
            <div class="col-md-12">
                <div class="card card-radius">
                    <div class="card-header bg-core ">
                       <span style="font-size: 13px">Transaction List</span>
                      <div class="card-tools">
                        <button class="btn btn-primary btn-sm" id="btn_refresh" type="button" >
                            <i class="fas fa-refresh"></i>
                        </button>
                        <button class="btn btn-success btn-sm" id="btn_add_ir" data-toggle="modal" type="button" data-target="#addIrModal">
                            <i class="fas fa-plus"></i>
                        </button>
                       
                      </div>
                    </div>
                    <div class="card-body">
                        <table class="datatable-bordered nowrap display" id="ir_table">
                            <thead>
                                <tr>
                                    <th  style="text-align: center">Request Code</th>
                                    <th  style="text-align: center">PIC</th>
                                    <th  style="text-align: center">Item</th>
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
@endsection
@include('transaction.ir.modal.add-ir')
@include('transaction.ir.modal.detail-ir')
@include('transaction.ir.modal.update-ir')
@push('custom-js')
@include('transaction.ir.ir-js')
@endpush
