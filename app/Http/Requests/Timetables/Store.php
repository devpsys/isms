<?php

namespace App\Http\Requests\Timetables;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest 
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
			'session_id' => 'required|exists:sessions,id|numeric',
			'section_id' => 'required|exists:sections,id|numeric',
			'term' => 'required|max:20',
			'published' => 'nullable|date',
			'config' => 'required|string',
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
     
        ];
    }

}
