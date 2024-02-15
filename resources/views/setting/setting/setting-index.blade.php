@extends('layouts.admin')
@section('title', 'Setting')
@section('content')
<div class="container">
    <div class="row justify-content-center">
          <div class="col-md-5">
            <div class="card card-radius">
                <div class="card-header bg-core">
                    Profile
                    <div class="card-tools">
                        <button class="btn btn-sm btn-warning" data-toggle="modal" id="btnSignatureModal" title="Update Signature " style="font-size:12px" data-target="#editSignatureModal">
                            <i class="fas fa-signature"></i>
                        </button>
                        <button class="btn btn-sm btn-primary" data-toggle="modal" title="Update Password" style="font-size:12px" data-target="#updatePassModal" onclick="clear_pass()">
                            <i class="fas fa-key"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                   <div class="form-group row">
                        <img style="width:25%;margin:auto" src="{{URL::asset('profile.png')}}" alt="">                     
                   </div>
                   <div class="container mt-2 justify-content-center ">
                        <div class="form-group row">
                            <div class="col-md-2 mt-2">
                                <p for="">NIK</p>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="nik" value="{{auth()->user()->nik}}" class="form-control" readonly>
                                <input type="hidden" id="signaturePad" value="{{auth()->user()->signature}}" class="form-control" readonly>
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
                    <button class="btn btn-success btn-sm" title="Update Profile" id="update_profile" style="float: right;">
                      <i class="fas fa-check"></i>
                    </button>
                </div>
            </div>
      </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
@include('setting.setting.modal.update-pass_modal')
@include('setting.setting.modal.edit-signature')
@endsection
@push('custom-js')
@include('setting.setting.setting-js')
@endpush