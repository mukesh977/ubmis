<?php

namespace App\Http\Requests\Sales;

use Illuminate\Foundation\Http\FormRequest;

class SalesRequest extends FormRequest
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
            'date' => 'required|date',
	        'company_id' => 'required|exists:companies,id',
	        'received_amount' => 'required|numeric',
	        'sales_category_id' => 'required'
        ];
    }

    public function messages(){
    	return[
    		'company_id.required' => 'The Office Name is Required.',
		   'sales_category_id.required' => 'You Must Select at least 1 Purpose.'
	    ];
    }
}
