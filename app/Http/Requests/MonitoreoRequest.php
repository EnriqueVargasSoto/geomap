<?php

namespace App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;

class MonitoreoRequest extends FormRequest
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
            'zonaSubmit'     => 'required|string|min:1|max:15',
            'rutaSubmit'     => 'required|string|min:1|max:15',
			'fechaSubmit'    => 'required|string|min:10|max:10',
			'vendedorSubmit' => 'required|string|min:1|max:15',
        ];
    }
 
}
