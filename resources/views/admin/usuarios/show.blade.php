@extends('layouts.frontend.master')
@section('style')
	<style>
		.table {
			margin-bottom: 0px;
		}
		.label {
			font-size: 13px;
		}
	</style>
@stop
@section('content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<section class="content">
			<div class="box box-primary">
				<div class="box-body">
					<h3> Detalle de Usuario </h3><br>
					<div class="table-responsive">
						<table class="table">
							<tbody>
                                <tr>
                                    <th>{!! Form::label('empresa', 'Empresa:') !!}</th>
                                    <td>{!! $model->getEmpresa->razonSocial !!}</td>
                                </tr>
                                <tr>
                                    <th>{!! Form::label('sucursal', 'Sucursal:') !!}</th>
                                    <td>{!! $model->getSucursal->nombre !!}</td>
                                </tr>
                                <tr>
                                    <th>{!! Form::label('perfil', 'Cargo:') !!}</th>
                                    <td>{!! $model->perfil->descripcion !!}</td>
                                </tr>
                                <tr>
                                    <th>{!! Form::label('id_person', 'Usuario') !!}</th>
                                    <td>{!! $model->usuario !!}</td>
                                </tr>
                                <tr>
                                    <th>{!! Form::label('nombre', 'Nombre:') !!}</th>
                                    <td>{!! $model->nombre !!}</td>
                                </tr>
                                <tr>
                                    <th>{!! Form::label('fecha', 'Fecha de creación:') !!}</th>
                                    <td>{!! $model->created_at !!}</td>
                                </tr>
                                <?php
                                    $zonas = \App\Models\Zona::porUsuario( $model->idEmpresa, $model->idSucursal, $model->idUsuario)->pluck('descripcion', 'idZona')->toArray();
                                ?>
                                <tr>
                                    <th>{!! Form::label('zonas', 'Zonas:') !!}</th>
                                    <td>
                                        @foreach($zonas as $id => $zona)
                                            {{  $id ." - ".$zona }} <br>
                                        @endforeach
                                    </td>
                                </tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="box-footer">
					<a href="{!! route('users.index') !!}" class="btn btn-default">Regresar</a>
				</div>
			</div>
		</section>
	</div>
	<!-- /.content-wrapper -->
@stop