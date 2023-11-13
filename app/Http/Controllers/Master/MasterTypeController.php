<?php

namespace App\Http\Controllers\Master;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Master\TypeModel;
use GrahamCampbell\ResultType\Result;
use Illuminate\Http\Request;

class MasterTypeController extends Controller
{
    function index() {
        return view('master.type.type-index');
    }
    function getType() {
        $data = TypeModel::all();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    function getActiveType() {
        $data = TypeModel::where('is_active',1)->get();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    function detailType(Request $request) {
        $detail = TypeModel::find($request->id);
        return response()->json([
            'detail'=>$detail,  
        ]);  
    }
    function addType(Request $request, StoreTypeRequest $storeTypeRequest) {
        try {
            $storeTypeRequest->validated();
            $post =[
                'name'          => $request->name,
                'initial'   => $request->initial,
                'is_active'     => 1
            ];
            TypeModel::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'Type successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Type failed to add',
                500
            );
        }
    }
    function updateStatusType(Request $request) {
        $status  = 500;
        $message = "Type failed to update";
        $post =[
            'is_active' => $request->is_active == 1 ? 0 : 1
        ];
        $update = TypeModel::find($request->id)->update($post);
        if($update){
            $status = 200;
            $message ='Type successfully updated';
        }
        return response()->json([
            'status'=>$status,  
            'message'=>$message,  
        ]);  
    }
    function deleteType(Request $request) {
        $status  = 500;
        $message = "Type failed to delete";
       
        $delete = TypeModel::find($request->id)->delete();
        if($delete){
            $status = 200;
            $message ='Type successfully deleted';
        }
        return response()->json([
            'status'=>$status,  
            'message'=>$message,  
        ]);  
    }

    function updateType(Request $request, UpdateTypeRequest $updateTypeRequest) {
        try {
            $updateTypeRequest->validated();
            $post =[
                'name'      => $request->name_edit,
                'initial'      => $request->initial_edit,
            ];
            TypeModel::find($request->id)->update($post);
            return ResponseFormatter::success(   
                $post,                              
                'Type successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Type failed to update',
                500
            );
        }
    }
}
