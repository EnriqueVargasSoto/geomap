  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
	<input id="fechaPorDefecto" value="{{ Auth::user()->fecha }}" hidden>
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
		@if(Session::get('active')== 'mapa')
		  <li class="active" ><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-fw fa-filter"></i></a></li>
		@endif
		<li class="{{ Session::get('active')== 'vendedores' ? 'active' : '' }}"><a href="#control-sidebar-dashboard" data-toggle="tab"><i class="fa fa-dashboard"></i></a></li>
		@if(Session::get('active')== 'mapa')
			<li><a href="#control-sidebar-stats" data-toggle="tab"><i class="fa fa-fw fa-map-o"></i></a></li>
		@endif
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content --> 
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
	  @if(Session::get('active')== 'mapa')
      <div class="tab-pane" id="control-sidebar-stats">
		<h4 class="control-sidebar-heading">MAPA</h4>
		<label class="control-sidebar-subheading">
            <div class="form-group">
                <label class="control-sidebar-subheading">
                <input id="checkAgruparClientes" type="checkbox" data-layout="fixed" class="minimal pull-right"  ><span class="label-checkbox">Agrupar clientes</span></label>
				<input id="checkAgruparPedidos" type="checkbox" data-layout="fixed" class="minimal pull-right" ><span class="label-checkbox">Agrupar pedidos</span></label>
            </div> 
		</label> 	  
		
	  </div>
	  <div class="tab-pane active" id="control-sidebar-settings-tab">
        
			<h4 class="control-sidebar-heading">FILTROS</h4> 
			<!--div class="form-group">
			<label class="control-sidebar-subheading">
			  <div class="form-group">
				<p>Sucursal</p>
				<select id="sucursales" class="form-control select2">
				  <option value="x">...</option>
				</select>
			  </div>  
			</label> 
			</div-->
			<div class="form-group">
				<label class="control-sidebar-subheading">
				  <div class="form-group">
					<p>Zona</p>
					<input type="text" class="form-control pull-right" id="zonas" readonly>
					<!--select id="zonas" class="form-control select2">
					  <option value="x">Ninguno</option>
					</select-->
				  </div>  
				</label> 
			</div>
			<div class="form-group">
				<label class="control-sidebar-subheading">
				  <div class="form-group">
					<p>Ruta</p>
					<input type="text" class="form-control pull-right" id="rutas" readonly>
					<!--select id="rutas" class="form-control select2" disabled>
					  <option value="x">Ninguna</option> 
					</select-->
				  </div>  
				</label> 
			</div>
			<div class="form-group">
				<label class="control-sidebar-subheading">
				  <div class="form-group">
					<p>Vendedor</p>
					<input type="text" class="form-control pull-right" id="vendedores" readonly>
					<!--select id="vendedores" class="form-control select2" disabled>
					  <option value="0">Ninguno</option> 
					</select-->
				  </div>  
				</label> 
			</div>
			<div class="form-group">
				<label class="control-sidebar-subheading">
				  <div class="form-group">
					<p>Fecha de Preventa</p>
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" class="form-control pull-right" id="fecha" value="{{ Auth::user()->fecha }}" readonly>
					</div> 
				  </div>  
				</label> 
			</div>
			<h4 class="control-sidebar-heading">Opciones</h4>
			<div class="form-group">
				<label class="control-sidebar-subheading">
					Refrescar mapa
					<a id="refrescarMapa" href="javascript:void(0)" class="text-green  pull-right"><i class="fa fa-refresh"></i></a>
				</label>
			</div>
			<div class="form-group">
				<label class="control-sidebar-subheading">
					Centrar mapa
					<a id="centrarMapa" href="javascript:void(0)" class="text-green  pull-right"><i class="fa fa-fw fa-street-view"></i></a>
				</label>
			</div>
			<div class="form-group">
				</br>
				<!-- button id="btnBuscar" class="btn mdn btn-success"><i class="fa fa-fw fa-search"></i> Buscar</button>
				<button id="btnLimpiar" class="btn mdn btn-default pull-right"><i class="fa fa-fw fa-trash"></i> Limpiar</button-->
			</div>
			<!-- /.form-group -->  
			<!--div class="form-group">
			<label class="control-sidebar-subheading"> 
			  <div class="form-group">
				<p class="setting">Rango de fechas:
					<a id="fechaConfiguracion" href="javascript:void(0)" class="text-white  pull-right"><i class="fa fa-fw fa-calendar-times-o pull-right"></i></a>
				</p>
				<div class="input-group date">
				  <div id="btnFecha" class="input-group-addon small-icon">
					<i class="fa fa-calendar"></i>
				  </div>
				  <input type="text" class="form-control hidden">
				  <input id="desde" type="text" placeholder="dd/mm/yyyy" class="form-control half-content">
				  <input id="hasta" type="text" class="form-control half-content">
				</div> 
			  </div>
			</label> 
			</div-->  
        
		<!-- /.tab-pane -->
	  </div>
	  @endif
      <!-- /.tab-pane -->
      <div class="tab-pane {{ Session::get('active')== 'vendedores' ? 'active' : '' }}" id="control-sidebar-dashboard">
            <h4 class="control-sidebar-heading">VENTAS</h4>
            <ul class="control-sidebar-menu">
                                
				<li class="row-dashboard"> 
					<h4 class="control-sidebar-subheading"> Clientes programados:  <span id="clientesProgramados" class="pull-right">0</span></h4>				
				</li>
				
				<li class="row-dashboard"> 
                    <h4 class="control-sidebar-subheading"> Cli. Efect. <span id="clientesConPedidos" class="label label-primary pull-right">0</span></h4>
                        <!--<div class="progress progress-xxs">
                            <div id="no-venta-sidebar" class="progress-bar progress-bar-danger">
								<label class="progress-label"id="clientesConPedidosPercent" > 0% </label>
							</div>
                        </div>--> 
                </li>
								
				<li class="row-dashboard"> 
					<h4 class="control-sidebar-subheading"> C.E.%:  <span id="clientesConPedidosPorcentaje" class="pull-right">0%</span></h4>					 
				</li>
				<li class="row-dashboard"> 
					<h4 class="control-sidebar-subheading"> Cant.Total:  <span id="totalPaquetes" class="label label-primary pull-right">0</span></h4>				 
				</li>
				<li class="row-dashboard"> 
					<h4 class="control-sidebar-subheading"> Cli.NP:  <span id="clientesNoPedido" class="label label-primary pull-right">0</span></h4>					 
				</li>
				<li class="row-dashboard"> 
					<h4 class="control-sidebar-subheading"> Cli.Efect.NP:  <span id="clientesVisitados" class="label label-primary pull-right">0</span></h4>					 
				</li>
				<li class="row-dashboard"> 
					<h4 class="control-sidebar-subheading"> C.E.NP%:  <span id="clientesVisitadosPorcentaje" class="pull-right">0%</span></h4>					 
				</li>
				<li class="row-dashboard"> 
					<h4 class="control-sidebar-subheading"> C.Total NP:  <span id="clientesNoVisitados" class="label label-primary pull-right">0</span></h4>					 
				</li>
				<li class="row-dashboard"> 
					<h4 class="control-sidebar-subheading"> Estado:  <span id="estadoVendedor" class="pull-right">0</span></h4>					 
				</li>
				<li class="row-dashboard"> 
					<h4 class="control-sidebar-subheading"> Visitados:  <span id="visitadosPorcentaje" class="pull-right">0%</span></h4>					 
				</li>
				<li class="row-dashboard"> 
					<h4 class="control-sidebar-subheading"> Imp.Total:  <span id="importeTotal" class="label label-primary pull-right">0</span></h4>					 
				</li>
				<li class="row-dashboard"> 
					<h4 class="control-sidebar-subheading"> DropPaquetes:  <span id="dropPaquetes" class="label label-primary pull-right">0</span></h4>					 
				</li>
				<li class="row-dashboard"> 
					<h4 class="control-sidebar-subheading"> DropSoles:  <span id="dropSoles" class="label label-primary pull-right">0</span></h4>					 
				</li>
            </ul>
        </div>
  </aside>
  <!-- /.control-sidebar -->