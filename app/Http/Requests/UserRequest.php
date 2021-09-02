<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'name'             => 'required|max:100',
            'identification'   => 'required|max:11',
            'cell_phone'       => 'nullable|max:10',
            'city_code'        => 'nullable|numeric',
            'email'            => 'required|email|max:100|unique:users,email,'.$this->user,         
            'password'         => 'required',            
        ];

        return $rules;
    }
}
