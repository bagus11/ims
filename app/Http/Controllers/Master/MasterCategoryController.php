<?php

namespace App\Http\Controllers\Master;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Master\CategoryModel;
use App\Models\MasterDepartment;
use App\Models\MasterLocation;
use Illuminate\Http\Request;

class MasterCategoryController extends Controller
{
    function index() {
        return view('master.category.category-index');
    }
    function getCategory() {
        $data = CategoryModel::with(['typeRelation','departmentRelation'])->get();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    function getActiveCategory(Request $request) {
        $data = CategoryModel::where('type_id','like','%'. $request->id .'%')
                            ->where( 'department_id','like','%'. $request->department_id .'%',)
                            ->get();
      
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    function detailCategory(Request $request) {
        $detail = CategoryModel::find($request->id);
        return response()->json([
            'detail'=>$detail,  
        ]);  
    }
    function addCategory(Request $request, StoreCategoryRequest $storeCategoryRequest) {
        try {
            $storeCategoryRequest->validated();
            $post =[
                'name'      => $request->name,
                'is_active' => 1,
                'type_id'   =>$request->type_id,
                'department_id'   =>$request->department_id
            ];
            CategoryModel::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'Category successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Category failed to add',
                500
            );
        }
    }
    function updateStatusCategory(Request $request) {
        $status  = 500;
        $message = "Category failed to update";
        $post =[
            'is_active' => $request->is_active == 1 ? 0 : 1
        ];
        $update = CategoryModel::find($request->id)->update($post);
        if($update){
            $status = 200;
            $message ='Category successfully updated';
        }
        return response()->json([
            'status'=>$status,  
            'message'=>$message,  
        ]);  
    }
    function updateCategory(Request $request, UpdateCategoryRequest $updateCategoryRequest) {
        try {
            $updateCategoryRequest->validated();
            $post =[
                'name'      => $request->name_edit,
                'type_id'   =>$request->type_id_edit
            ];
            CategoryModel::find($request->id)->update($post);
            return ResponseFormatter::success(   
                $post,                              
                'Category successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Category failed to update',
                500
            );
        }
    }
    function deleteCategory(Request $request) {
        $status  = 500;
        $message = "Category failed to delete";
       
        $delete = CategoryModel::find($request->id)->delete();
        if($delete){
            $status = 200;
            $message ='Category successfully deleted';
        }
        return response()->json([
            'status'=>$status,  
            'message'=>$message,  
        ]);  
    }

    function getLocation() {
        $data = MasterLocation::all();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    function getActiveDepartment(Request $request) {
        $data = MasterDepartment::all();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
}
