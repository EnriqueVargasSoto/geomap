<?php
/**
 * Created by ExpedioDigital.
 * User: Monica Toribio Rojas
 * Date: 29/01/2018
 * Time: 06:38
 */

namespace App\Http\Requests\Admin;

use App\Models\Usuario;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest  extends FormRequest
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
            'cargo'        => 'required|string',
            'empresa'      => 'required|min:3|max:15',
            'sucursal'     => 'required|string|min:1|max:15',
            'nombre'       => 'min:3|max:45',
            'usuario'      => 'required|string|min:1|max:15',
            'clave'        => 'required|min:3|max:32',
            'confirmacion' => 'required|same:clave',
            'zonas'        => 'required_if:cargo,"2"'
        ];
    }

    protected function getValidatorInstance()
    {
        return parent::getValidatorInstance()->after(function($validator){
            // Call the after method of the FormRequest (see below)
            $this->after($validator);
        });
    }


    public function after($validator)
    {
        if(!empty($this->empresa) && !empty($this->sucursal) && !empty($this->usuario)){

            $model = Usuario::where('usuario', $this->usuario)->where('idEmpresa',  $this->empresa )->where('idSucursal',  $this->sucursal )->where('deleted', '=', 0 )->first();

            if($model){
                $validator->errors()->add('usuario','Ya existe un usuario con ese nombre.');
            }
        }
    }
}