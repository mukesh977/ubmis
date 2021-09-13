<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;

class UserSalesRequest extends FormRequest
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
		    'user_id' => 'required|exists:users,id',
		    'target_id' => 'required|exists:targets,id',
		    'total_sales' => 'required|numeric'
	    ];
    }

    public function messages()
    {
	    return [
		    'user_id.required' => 'Target User is required',
		    'target_id.required'  => 'Target is required',
	    ];
    }
}
