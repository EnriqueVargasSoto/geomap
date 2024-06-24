 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar"> 
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU PRINCIPAL</li>
        @if ( Auth::user()->cargo === "Admin" )
         <li class="{{ Session::get('active')== 'usuarios' ? 'active menu-open' : '' }} treeview ">
              <a href="{{ url('admin/users') }}" > <i class="fa fa-fw fa-group"></i> <span>Usuarios</span></a>
              <ul class="treeview-menu">
                  <li class="{{ Session::get('active')== 'usuarios' && Session::get('hijo')== 'nuevo' ? 'active' : '' }}"><a href="{{ url('admin/users/create') }}"><i class="fa fa-circle-o"></i> Nuevo  </a></li>
                  <li class="{{ Session::get('active')== 'usuarios' && Session::get('hijo')== 'lista' ? 'active' : '' }}"><a href="{{ url('admin/users') }}"><i class="fa fa-circle-o"></i> Lista </a></li>
              </ul>
         </li>
        @else
        <!--li class="{{ Session::get('active')== 'mapa' ? 'active' : '' }}"><a href="{{ url('/geolocalizacion') }}"><i class="fa fa-fw fa-map-signs"></i> <span>Geolocalización</span></a></li-->	
		<li class="{{ Session::get('active')== 'vendedores' ? 'active' : '' }}"><a href="{{ url('monitoreovendedores') }}"><i class="fa fa-laptop"></i> <span>Monitoreo</span></a></li>	
		<li class="{{ Session::get('active')== 'panelcentral' ? 'active' : '' }}"><a href="{{ url('panelcentral') }}"><i class="fa fa-dashboard"></i> <span>Panel Central</span></a></li>
        <li class="{{ Session::get('active')== 'encuesta' ? 'active menu-open' : '' }} treeview ">
          <a href="" > <i class="fa fa-edit"></i> <span>Encuestas</span></a>
          <ul class="treeview-menu">             
              <li class="{{ Session::get('hijo')== 'lista' ? 'active' : '' }}"><a href="{{ url('encuesta') }}"><i class="fa fa-circle-o"></i> Lista </a></li>
              <!--li class="{{ Session::get('hijo')== 'nuevo' ? 'active' : '' }}"><a href="{{ url('encuesta/nueva') }}"><i class="fa fa-circle-o"></i> Nuevo </a></li-->
          </ul>
        </li>
		<li class="{{ Session::get('active')== 'avancexmarca' ? 'active' : '' }}"><a href="{{ url('avancexmarca') }}"><i class="fa fa-table"></i> <span>Ventas x Marca</span></a></li>	
		<li class="{{ Session::get('active')== 'avancexcuota' ? 'active' : '' }}"><a href="{{ url('avancexcuota') }}"><i class="fa fa-fw fa-star-half-o"></i> <span>Avance Cuota</span></a></li>
		<li class="{{ Session::get('active')== 'hrindicadorxvendedor' ? 'active' : '' }}"><a href="{{ url('hrindicador') }}"><i class="fa fa-fw fa-line-chart"></i> <span>Indicadores</span></a></li>
    {{--<li class="{{ Session::get('active')== 'campeonato' ? 'active' : '' }}"><a href="{{ url('campeonato') }}"><i class="fa fa-fw fa-arrow-up"></i> <span>Incentivos</span></a></li>--}}

    {{--<li class="{{ Session::get('campeonato')== 'campeonato' ? 'active menu-open' : '' }} treeview ">
          <a href="" > <i class="fa fa-edit"></i> <span>Incentivos</span></a>
          <ul class="treeview-menu">             
              <li class="{{ Session::get('campeonato')== 'campeonato' ? 'active' : '' }}"><a href="{{ url('campeonato') }}"><i class="fa fa-circle-o"></i> Avance Venta </a></li>
              <li class=""><a href="#"><i class="fa fa-circle-o"></i> Foco Cobertura </a></li>
              <li class=""><a href="#"><i class="fa fa-circle-o"></i> Innovación Cobertura </a></li>
          </ul>
    </li>

    <li class="{{ Session::get('active')== 'maestros' ? 'active' : '' }}"><a href="{{ url('maestros') }}"><i class="fa fa-fw fa-cog"></i> <span>Maestros</span></a></li>--}}
		
    

		<li class="header">EXTRAS</li>
		<li><a href="javascript:void(0)" class="signout"> <i class="fa fa-fw fa-sign-out"></i> <span>Salir</span></a></li>
    
      <img class="logo-nav" src="images/xalesmap_icon.png" style="max-width: 204px;top:600px;" alt="Logo">
    
		@endif
      </ul>
	  
	
    </section>
    <!-- /.sidebar -->
  </aside>