<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailRequest extends FormRequest
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
            'email'    => 'required|email|max:100',         
            'subject'  => 'required|max:200', 
            'body'     => 'required',            
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'email'        => 'Correo',
            'subject'      => 'Asunto',
            'body'         => 'Contenido mensaje',
        ];
    }
}
