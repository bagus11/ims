<?php

namespace App\Http\Requests;

use App\Models\Master\ProductModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $post=[];
        $getDataold = ProductModel::find($request->id);
        if($request->name_edit == $getDataold->name){
            $post=[
                'name_edit'      =>'required',
                'type_id_edit'   =>'required',
                'category_id_edit'   =>'required',
                'location_id_edit'   =>'required',
            ];
        }else{
            $post=[
                'name_edit'      =>['required','unique:product_model,name'],
                'type_id_edit'   =>'required',
                'category_id_edit'   =>'required',
                'location_id_edit'   =>'required',
            ];
        }
     
      return $post;
    }
}
