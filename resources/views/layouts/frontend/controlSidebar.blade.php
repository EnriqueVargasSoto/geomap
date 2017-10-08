  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active" ><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-fw fa-map-o"></i></a></li>
	  <li><a href="#control-sidebar-stats" data-toggle="tab"><i class="fa fa-wrench"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content --> 
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats">
		<h3 class="control-sidebar-heading">Configuración General</h3>
		<label class="control-sidebar-subheading">
		  <div class="form-group">
			  <label class="control-sidebar-subheading">
			  <input id="checkAgrupar" type="checkbox" data-layout="fixed" class="pull-right" checked> Agrupar marcadores</label>
		  </div>
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
		</label>
	  </div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane active" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">Configuración Mapa</h3> 
          <div class="form-group">
            <label class="control-sidebar-subheading">
              <div class="form-group">
                <p>Sucursal</p>
                <select id="sucursales" class="form-control select2">
				  <option value="0">...</option> 
                </select>
              </div>  
            </label> 
          </div>
		  <!-- /.form-group--> 
		  <div class="form-group">
            <label class="control-sidebar-subheading">
              <div class="form-group">
                <p>Ruta</p>
                <select id="rutas" class="form-control select2" disabled>
                  <option value="x">Ninguna</option> 
                </select>
              </div>  
            </label> 
          </div>
          <!-- /.form-group selected="selected" --> 
		  <!--div class="form-group">
            <label class="control-sidebar-subheading">
              <div class="form-group">
                <p>Vendedor</p>
                <select id="vendedores" class="form-control select2" disabled>
                  <option value="0">Ninguno</option> 
                </select>
              </div>  
            </label> 
          </div-->
          <!-- /.form-group --> 
          <div class="form-group">
            <label class="control-sidebar-subheading"> 
              <div class="form-group">
                <p class="setting">Rango de fechas: <i class="fa fa-fw fa-calendar-times-o pull-right"></i></p> 
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
          </div>  
          <!-- /.form-group -->
        </form> 
      <!-- /.tab-pane -->
    </div>
  
  </aside>
  <!-- /.control-sidebar -->