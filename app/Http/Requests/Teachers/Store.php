<?php

namespace App\Http\Requests\Teachers;

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
//			'user_id' => 'required|exists:users,id|numeric',
//			'staff_number' => 'required|max:15',
			'title' => 'required|in:Malam,Malama,Ustaz,Ustaziya,Sheikh',
			'fullname' => 'required|max:100',
			'gsm' => 'required|max:15',
			'address' => 'required|string',
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
