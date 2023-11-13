@extends('layouts.admin')
@section('title', 'Setting')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                Profile
                </div>
                <div class="card-body">
                   <div class="form-group row">
                        <img style="width:25%;margin:auto" src="{{URL::asset('profile.png')}}" alt="">                     
                   </div>
                   <div class="form-group row justify-content-center">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#updatePassModal" onclick="clear_pass()">
                            <i class="fas fa-lock"></i> Change Password
                        </button>
                   </div>
                   <div class="container mt-2 justify-content-center ">
                        <div class="form-group row">
                            <div class="col-md-2 mt-2">
                                <p for="">NIK</p>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="nik" value="{{auth()->user()->nik}}" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row ">
                            <div class="col-md-2 mt-2">
                                <p for="">Email</p>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="email_user" value="{{auth()->user()->email}}" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-2 mt-2">
                                <p for="">Name</p>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="user_name" value="{{auth()->user()->name}}" class="form-control">
                            </div>
                        </div>
                      
                       
                   </div>

                </div>
                <div class="card-footer">
                    <button class="btn btn-success" id="update_profile" style="float: right;">
                       Update Profile
                    </button>
                </div>
            </div>
      </div>
    </div>
</div>

@include('setting.setting.modal.update-pass_modal')
@endsection
@push('custom-js')
@include('setting.setting.setting-js')
@endpush