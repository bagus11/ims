<?php

namespace App\Http\Requests;

use App\Models\Master\CategoryModel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateCategoryRequest extends FormRequest
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
    public function rules()
    {
        $post=[
            'name_edit'=>'required',
            'type_id_edit'=>'required'
        ];
        return $post;
    }
}
