<?php

namespace App\Http\Controllers\PettyCash\Master;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddSubCategoryRequest;
use App\Http\Requests\updateSubCategoryRequest;
use App\Models\MasterSubCategory;
use Illuminate\Http\Request;

class MasterSubCategoryController extends Controller
{
    function index() {
        return view('pettycash.master.subcategory.master_subcategory-index');
    }
    function getSubCategory() {
        $data = MasterSubCategory::with(['categoryRelation'])->get();
        return response()->json([
            'data'=>$data,
        ]);  
    }
    function addSubCategory(Request $request, AddSubCategoryRequest $addSubCategoryRequest) {
        try {
            $addSubCategoryRequest->validated();
            $fileName           = '';
            $post =[
                'name'                      => $request->name,
                'description'               => $request->description,
                'category_id'               => $request->category_id,
                'status'                    => 1,
            ];
            MasterSubCategory::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'Sub Category successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Sub Category failed to add',
                500
            );
        }
    }
    function activateSubCategoryPC(Request $request){
        try {
            $post =[
                'status'=> $request->status == 1 ? 0 : 1,
            ];
            // dd($post);
            MasterSubCategory::find($request->id)->update($post);
            return ResponseFormatter::success(   
                $post,                              
                'Sub Category successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Sub Category failed to update',
                500
            );
        }
    }
    function detailSubCategory(Request $request) {
        $detail = MasterSubCategory::with(['categoryRelation'])->where('id',$request->id)->first();
        return response()->json([
            'detail'=>$detail,
        ]);  
    }
    function updateSubCategory(Request $request, updateSubCategoryRequest $updateSubCategoryRequest) {
        try {
            $updateSubCategoryRequest->validated();
            $post =[
                'name'                      => $request->name_edit,
                'description'               => $request->description_edit,
            ];
            // dd($request);
            MasterSubCategory::find($request->id)->update($post);
            return ResponseFormatter::success(   
                $post,                              
                'Sub Category successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Sub Category failed to update',
                500
            );
        }
    }
    function getActiveSubCategory(Request $request) {
        $data = MasterSubCategory::where('category_id',$request->id)->where('status',1)->get();
        return response()->json([
            'data'=>$data,
        ]);  
    }
}
