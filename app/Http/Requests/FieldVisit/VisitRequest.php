<?php

namespace App\Http\Requests\FieldVisit;

use Illuminate\Foundation\Http\FormRequest;

class VisitRequest extends FormRequest
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
	        'visit_category_id' => 'required|exists:visit_categories,id',
	        'company_id' => 'required|exists:companies,id',
	        'date' => 'required|date',
	        'email_address' => 'required|email',
            'address' => 'required',
	        'visited_to' => 'required',
	        'contact_person' => 'required',
	        'requirements' => 'required',
	        'project_status' => 'required',
	        'project_scope' => 'required',
        ];
    }
}
