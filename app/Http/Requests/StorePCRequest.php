<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePCRequest extends FormRequest
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
        return [
            'period' =>'required',
            'bank_id' =>'required',
            'total_pc' =>'required',
            'location_id' =>'required',
            'no_check' =>['required', 'unique:master_petty_cash'],
        ];
    }
}
