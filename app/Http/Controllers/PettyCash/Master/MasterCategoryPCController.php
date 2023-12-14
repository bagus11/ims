<?php

namespace App\Http\Controllers\PettyCash\Master;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterCategoryPC;
use App\Http\Requests\UpdateMasterCategoryPC;
use App\Models\PettyCash\Master\MasterCategoryPC;
use Illuminate\Http\Request;

class MasterCategoryPCController extends Controller
{
    function index() {
        return view('pettycash.master.master_category.master_category_pc-index');
    }
    function getCategoryPC() {
        $data = MasterCategoryPC::all();
        return response()->json([
            'data'=>$data,
        ]); 
    }
    function getActiveCategoryPC() {
        $data = MasterCategoryPC::where('status',1)->get();
        return response()->json([
            'data'=>$data,
        ]); 
    }
    function detailCategoryPC(Request $request) {
        $data = MasterCategoryPC::find($request->id);
        return response()->json([
            'detail'=>$data,
        ]); 
    }
    function addCategoryPC(Request $request, StoreMasterCategoryPC $storeMasterCategoryPC){
        try {
            $storeMasterCategoryPC->validated();
            $post =[
                'name'                      => $request->name,
                'description'               => $request->description,
                'min_transaction'           => $request->min_transaction,
                'max_transaction'           => $request->max_transaction,
                'duration'                  => $request->duration,
                'status'                    => 1,
            ];
            // dd($post);
            MasterCategoryPC::create($post);
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
    function UpdateCategoryPC(Request $request, UpdateMasterCategoryPC $updateMasterCategoryPC){
        try {
            $updateMasterCategoryPC->validated();
            $post =[
                'description'               => $request->description_edit,
                'min_transaction'           => $request->min_transaction_edit,
                'max_transaction'           => $request->max_transaction_edit,
                'duration'                  => $request->duration_edit,
     
            ];
            // dd($post);
            MasterCategoryPC::find($request->id)->update($post);
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
    function activateCategoryPC(Request $request) {
        try {
            $post =[
                'status'                => $request->status == 1 ? 0 : 1,
            ];
            // dd($post);
            MasterCategoryPC::find($request->id)->update($post);
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
}
