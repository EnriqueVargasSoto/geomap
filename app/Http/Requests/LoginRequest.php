<?php

namespace App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'usuario'       => 'required|string',
			'empresa'     => 'min:3|max:15',
			'sucursal'    => 'string|min:1|max:15',
            'clave'         => 'required|min:3|max:32',
        ];
    }
}
