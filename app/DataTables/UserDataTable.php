<?php

namespace App\DataTables;

use App\Models\Usuario;
use Carbon\Carbon;
use Form;
use DB;
use Yajra\Datatables\Services\DataTable;

class UserDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('actions', function ($data) {
                return Form::open(['route' => ['users.destroy', $data->idUsuario], 'method' => 'delete']) . '
                            <div class=\'btn-group\'>
                                <a href="'.route('users.show', [$data->idUsuario]). '" class=\'btn btn-default btn-xs\'><i class="glyphicon glyphicon-eye-open"></i></a>
                                <a href="'.route('users.edit', [$data->idUsuario]). '" class=\'btn btn-default btn-xs\'><i class="glyphicon glyphicon-edit"></i></a>'.
                                Form::button('<i class="glyphicon glyphicon-trash"></i>', [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'onclick' => "return confirm('Esta seguro de eliminar al usuario?')"
                                ]).'</div>'.
                Form::close();
            })->make(true);
    }

    public function query()
    {
        $users = Usuario::join('Empresa', 'Empresa.idEmpresa', '=', 'Web_Usuario.idEmpresa')
                                      ->join('Web_Perfil', 'Web_Perfil.idPerfil', '=', 'Web_Usuario.idPerfil')
                                      ->join('Sucursal', function ($join) {
                                            $join->on('Sucursal.idSucursal', '=', 'Web_Usuario.idSucursal')
                                                 ->on('Sucursal.idEmpresa','=', 'Web_Usuario.idEmpresa' );
                                      })->where('deleted',0)->select('Empresa.razonSocial','Sucursal.nombre','Web_Perfil.descripcion','Web_Usuario.usuario','Web_Usuario.clave','Web_Usuario.idUsuario');
        return $this->applyScopes( $users );
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns(array_merge(
                $this->getColumns(),
                [
                    'actions' => [
                        'orderable' => false,
                        'searchable' => false,
                        'printable' => false
                    ]
                ]
            ))
            ->parameters([
                'dom' => 'Bfrltip',
                'scrollX' => true,
                'lengthMenu' => [ [5, 8, 10, 25, -1],["5", "8", "10", "25", "Todo"] ],
                'buttons' => [],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'Empresa' => ['name' => 'Empresa.razonSocial', 'data' => 'razonSocial'],
            'Sucursal' => ['name' => 'Sucursal.nombre', 'data' => 'nombre'],
            'Cargo' => ['name' => 'Web_Perfil.descripcion', 'data' => 'descripcion'],
            'Usuario' => ['name' => 'Web_Usuario.usuario', 'data' => 'usuario'],
            'clave' => ['name' => 'Web_Usuario.clave', 'data' => 'clave', 'visible' => false, 'exportable' => false],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ListaUsuarios'.Carbon::now();
    }
}
