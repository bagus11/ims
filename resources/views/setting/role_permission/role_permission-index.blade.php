@extends('layouts.admin')
@section('title', 'Role & Permission')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    {{-- Role --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <b class="headerTitle">Role</b>
                    <div class="card-tools">
                        <button class="btn btn-success btn-sm" id="btn_add_role" data-toggle="modal" type="button" data-target="#addRoleModal">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered" id="roles_table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    {{-- Role --}}
    {{-- Permission --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <b class="headerTitle">Permission</b>
                    <div class="card-tools">
                        <button class="btn btn-success btn-sm" id="btn_add_permission" data-toggle="modal" type="button" data-target="#addPermissionModal">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="permission_table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    {{-- Permission --}}
  </div>
</div>
@include('setting.role_permission.modal.add_roles')
@include('setting.role_permission.modal.edit_roles')
@include('setting.role_permission.modal.add_permission')
@endsection
@push('custom-js')
    @include('setting.role_permission.role_permission-js')
@endpush
