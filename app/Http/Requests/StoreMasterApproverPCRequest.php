<?php

namespace App\Http\Requests;

use App\Models\PettyCash\Master\MasterApproverPC;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class StoreMasterApproverPCRequest extends FormRequest
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
        $validation = MasterApproverPC::where([
            'location_id' =>$request->location_id,
            'department_id' =>$request->department_id
        ])->count();
        if($validation == 0){
          $post = [
                'step' =>['integer','required'],
                'location_id' =>['integer','required'],
                'department_id' =>['integer','required'],
               
            ];
        }else{
            $post = [
                  'step' =>['integer','required'],
                  'location_id' =>['integer','required','unique:master_approver_pc,location_id'],
                  'department_id' =>['integer','required'],
                 
              ];

        }
        return $post;
    }
}
