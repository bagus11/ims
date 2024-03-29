<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\UpdateMasterSignatureRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    function index() {
        return view('setting.setting.setting-index');
    }
    public function update_user(Request $request)
    {
        $user_name = $request->user_name;
        
        $status =500;
        $message ='Data failed to save';
        $userEmailValidation = User::find(auth()->user()->id);
        $post =[];

        if($request->email_user == $userEmailValidation->email){
            $validator = Validator::make($request->all(),[
                'user_name'=>['required']      
            ]);
            $post=[
                'name'=>$request->user_name,
            ];
        }else{
            $validator = Validator::make($request->all(),[
                'user_name'=>['required'],
                'email_user'=>['required','unique:users,email'],
            ]);
            $post=[
                'name'=>$request->user_name,
                'email'=>$request->email_user,
            ];
        }
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $user = User::find(auth()->user()->id);
            $user->update($post);
            if($user){
                $status =200;
                $message='Data successfully inserted';
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);

    }
    public function change_password(Request $request)
    {
        $current_password = $request->current_password;
        $new_password = $request->new_password;
        $confirm_passowrd = $request->confirm_passowrd;
        $status =500;
        $message ='Data failed to save';
        $validator = Validator::make($request->all(),[
            'current_password'=>['required', new MatchOldPassword],
            'new_password' =>'required|min:8',
            'confirm_password'=>'same:new_password',
        ],[
            
            'current_password.required'=>'Password sekarang harus diisi',
            'new_password.required'=>'Password baru harus diisi',
            'new_password.min'=>'Password baru minimal 8 karakter',
            'confirm_password.same'=>'Password tidak sama dengan password baru',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>$validator->errors(), 
                'status'=>422
            ]);
        }else{
            $user = User::find(auth()->user()->id);
            $user->update(['password'=> Hash::make($new_password)]);
            if($user){
                $status =200;
                $message='Data successfully inserted';
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);

    }
    function updateSignature(Request $request, UpdateMasterSignatureRequest $updateMasterSignatureRequest) {
        try {
            $updateMasterSignatureRequest->validated();
            $post =[
                'signature'     => $request->signature
            ];
            // dd($request->user_id);
            User::where('id', auth()->user()->id)->update($post);
            return ResponseFormatter::success(    
                $post,                            
                'Signature successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Signature failed to update',
                500
            );
        }
    }
}
