<?php

namespace App\Http\Requests\FieldVisit;

use Illuminate\Foundation\Http\FormRequest;

class NextFieldVisitRequest extends FormRequest
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
            'next_visit_comments' => 'required',
            'next_visit_date' => 'required|date',
        ];
    }

    public function messages()
    {
    	return [
    		'company_id.required' => 'Office Name is Required.',
    		'next_visit_comments.required' => 'Word/Comments is Required.'
	    ];
    }
}
