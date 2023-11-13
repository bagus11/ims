@extends('layouts.admin')
@section('title', 'User Access')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    {{-- Role --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <b class="headerTitle">Role User</b>
                    <div class="card-tools">
                        <button class="btn btn-success btn-sm" id="btn_add_role_user" data-toggle="modal" type="button" data-target="#addRoleUserModal">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered" id="role_user_table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
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
                    <b class="headerTitle">Role Permission</b>
                    <div class="card-tools">
                     
                    </div>
                </div>
                <div class="card-body">
                    <table class="datatable-bordered nowrap display" id="role_permission_table">
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
@include('setting.user_access.modal.add_roleUser')
@include('setting.user_access.modal.edit_roleUser')
@include('setting.user_access.modal.add_rolePermission')
@include('setting.user_access.modal.edit_rolePermission')
@endsection
@push('custom-js')
    @include('setting.user_access.user_access-js')
@endpush
