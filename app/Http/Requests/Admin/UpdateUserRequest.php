<?php
/**
 * Created by ExpedioDigital.
 * User: Monica Toribio Rojas
 * Date: 7/02/2018
 * Time: 18:46
 */

namespace App\Http\Requests\Admin;


use App\Models\Usuario;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cargo'        => 'required|string',
            'empresa'      => 'required|string|min:3|max:15',
            'sucursal'     => 'required|string|min:1|max:15',
            'nombre'       => 'min:3|max:45',
            'usuario'      => 'required|string|min:1|max:12',
            'clave'        => 'min:3|max:32',
            'confirmacion' => 'same:clave',
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

            $model = Usuario::where('usuario', $this->usuario)->where('idEmpresa',  $this->empresa )->where('idSucursal',  $this->sucursal )->where('idUsuario', '!=', $this->_id )->where('deleted', '=', 0 )->first();

            if($model){
                $validator->errors()->add('usuario','Ya existe un usuario con ese nombre en la misma sucursal.');
            }
        }
    }
}