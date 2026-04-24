
<div class="card mt-3" style="border:none; background-color: #fff; ">

	
	<p class="card-header text-white font-weight-bold text-left" id="titulo" style="background: #98989A; font-size: 20px;"><i class="fa fa-user"></i> Registro de Usuarios </p>

	<div class="card-body" id="body">
		<div class="row text-left mb-2">
			<div class="col-md-6">
				<span class="text-left text-danger font-weight-bold" style="font-size: 13px;">Los campos marcados con (*) son obligatorios</span>
			</div>
		</div>

		<hr>

		<form id="formDatosRegUsuario">

		
				<div class="row text-left">
						<div class="col-md-4">
							<div class="form-group">
								<label><span class="text-danger font-weight-bold">*</span> Nombre(s):</label>
								<input type="hidden" id="hiddenidUsuario" name="hiddenidUsuario" value="0"></input>
								<input type="text" class="form-control form-control-sm" id="txtNombre" name="txtNombre" placeholder="Ingresa Nombre"  autofocus="focus">
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label><span class="text-danger font-weight-bold">*</span> Apellido Paterno:</label>
								<input type="text" class="form-control form-control-sm" id="txtApaterno" name="txtApaterno" placeholder="Ingresa Primer Apellido" required>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label><span class="text-danger font-weight-bold"></span>Apellido Materno:</label>
								<input type="text" class="form-control form-control-sm" id="txtAmaterno" name="txtAmaterno" placeholder="Ingresa Segundo Apellido" required>
							</div>
						</div>
				</div>
		


			<div class="row text-left">
					<div class="col-md-2">
						<div class="form-group">
							<label><span class="text-danger font-weight-bold">*</span> RFC:</label>
							<input type="text" class="form-control form-control-sm" id="txtRFC" name="txtRFC" placeholder="Ingresa RFC" required autofocus="focus">
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group">
							<label><span class="text-danger font-weight-bold">*</span> CURP:</label>
							<input type="text" class="form-control form-control-sm" id="txtCURP" name="txtCURP" placeholder="Ingresa CURP" required autofocus="focus">
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label><span class="text-danger font-weight-bold">*</span> Correo Electrónico:</label>
							<input type="text" class="form-control form-control-sm" id="txtCorreo" name="txtCorreo" placeholder="Ingresa correo" required autofocus="focus">
						</div>
					</div>

					<div class="col-md-3">
					<div class="form-group">
						<label><span class="text-danger font-weight-bold">*</span>Entidad Federativa:</label>
						<select class="form-control form-control-sm" id="dlistEntFed" name="dlistEntFed"  required>
							<option value = "00">Seleccione Entidad...</option>
							<option value = "01">Aguascalientes</option>
							<option value = "02">Baja California</option>
							<option value = "03">Baja California Sur</option>
							<option value = "04">Campeche</option>
							<option value = "05">Coahuila de Zaragoza</option>
							<option value = "06">Colima</option>
							<option value = "07">Chiapas</option>
							<option value = "08">Chihuahua</option>
							<option value = "09">Ciudad de México</option>
							<option value = "10">Durango</option>
							<option value = "11">Guanajuato</option>
							<option value = "12">Guerrero</option>
							<option value = "13">Hidalgo</option>
							<option value = "14">Jalisco</option>
							<option value = "15">Estado de México</option>
							<option value = "16">Michoacán de Ocampo</option>
							<option value = "17">Morelos</option>
							<option value = "18">Nayarit</option>
							<option value = "19">Nuevo León</option>
							<option value = "20">Oaxaca</option>
							<option value = "21">Puebla</option>
							<option value = "22">Querétaro</option>
							<option value = "23">Quintana Roo</option>
							<option value = "24">San Luis Potosí</option>
							<option value = "25">Sinaloa</option>
							<option value = "26">Sonora</option>
							<option value = "27">Tabasco</option>
							<option value = "28">Tamaulipas</option>
							<option value = "29">Tlaxcala</option>
							<option value = "30">Veracruz de Ignacio de la Llave</option>
							<option value = "31">Yucatán</option>
							<option value = "32">Zacatecas</option>
						</select>
					</div>
				</div>
			</div>		

			<div class="row text-left">
					<div class="col-md-2">
						<div class="form-group">
							<label><span class="text-danger font-weight-bold">*</span>Rol:</label>
							<select class="form-control form-control-sm" id="dlistRol" name="dlistRol"  required>
								<option value = "0">Seleccione Rol...</option>
								<option value = "1">Administrador</option>
								<option value = "2">Enlace Estatal</option>
								<option value = "3">Consulta</option>
							</select>
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group">
							<label><span class="text-danger font-weight-bold"></span> Teléfono de Contacto:</label>
							<input type="text" class="form-control form-control-sm" id="txtTelefono" name="txtTelefono"   maxlength="10" placeholder="Ingresa Número Telefónico" required>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label><span class="text-danger font-weight-bold">*</span>Usuario:</label>
							<input type="text" class="form-control form-control-sm" id="txtUsuario" name="txtUsuario" placeholder="Ingresa Nombre de Usuario" required>
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group">
							<label><span class="text-danger font-weight-bold">*</span>Contraseña:</label>
							<input type="text" class="form-control form-control-sm" id="txtContrasena" name="txtContrasena" placeholder="Ingresa Contraseña" required>
						</div>
					</div>

			</div>	


			<div class="row">
				<div class="col-md-6 text-right">
					<div class="form-group">
						<button  type="button" id="btnCancelEditUsr" class="btn boton btn-sm" style="visibility: hidden; opacity: 0;"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Cancelar</button>
					</div>
				</div>
				<div class="col-md-6 text-left">
					<div class="form-group">
						<button  type="button" id="btnGuardarRegUsuario" class="btn boton btn-sm"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Guardar Usuario</button>
					</div>
				</div>
			</div>

		</form>	


		<div class="card mt-5" style="border:none; background-color: #fff; ">
			<p class="card-header text-white font-weight-bold text-left" id="titulo" style="background: #691C32;"> </p>

			<div class="card-body" id="body">

				<table id="tblUsuariosList" class="table display nowrap table-hover table-bordered" style="width:100%">
					<thead>
						<tr style="font-size: 12px; background: #691C32; color: #fff;">
							<th>Nombre</th>
							<th>Cve. Usuario</th>
							<th>Correo</th>
							<th>Teléfono Contacto</th>
							<th>Rol</th>
							<th>Entidad</th>
							<th>Fecha de Alta</th>
							<th>Usuario Registro</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>

					 <?php

						foreach ($tablaRegUsuarios as $dato){

					 ?> 
							<tr style="font-size: 11px;">
								<td><?php echo $dato->NOMBRE_COMPLETO; ?></td>
								<td><?php echo $dato->USUARIO; ?></td>
								<td><?php echo $dato->CORREO; ?></td>
								<td><?php echo $dato->TELEFONO_CONTACTO; ?></td>
								<td><?php echo $dato->ROL; ?></td>
								<td><?php echo $dato->ENTIDAD_FEDERATIVA; ?></td>
								<td><?php echo $dato->FECHA_ALTA; ?></td>
								<td><?php echo $dato->USUARIO_REG; ?></td>

								 <td>

									  <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Editar Usuario" onclick="EditarUsuario(<?php echo $dato->ID_USUARIO; ?>)" ><i class="fa fa-pencil" aria-hidden="true"></i></button>

									   <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Baja de Usuario" onclick="BajaUsuario(<?php echo $dato->ID_USUARIO; ?>)" ><i class="fa fa-trash" aria-hidden="true"></i></button>

								</td>
							</tr>
						 <?php } ?> 

					</tbody>
				</table>
			</div>
		</div>




  		<div id="respuesta"></div> 


  	</div>
</div>		




<script>

	//SCRIPT PARA DATATABLE
		$(document).ready(function() {

			var table = $('#tblUsuariosList').DataTable( {
				language: {
					"lengthMenu": "Mostrar _MENU_ registros",
					"zeroRecords": "No se encontraron resultados",
					"info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
					"infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
					"infoFiltered": "(filtrado de un total de _MAX_ registros)",
					"sSearch": "Buscar:",
					"oPaginate": {
						"sFirst": "Primero",
						"sLast":"Último",
						"sNext":"Siguiente",
						"sPrevious": "Anterior"
					},
					"sProcessing":"Procesando...",
				},

				responsive: true,
				scrollX: true,
				lengthChange: false,
				buttons: [ 'copy', 'excel' ]
			} );

			table.buttons().container()
			.appendTo( '#tblUsuariosList_wrapper .col-md-6:eq(0)' );
		} );



	    $("#btnGuardarRegUsuario").click(function(){

   
    		if( $("#txtNombre").val() == '' ||  $("#txtApaterno").val() == '' ||  $("#txtRFC").val() == '' ||  $("#txtCURP").val() == '' || $("#txtCorreo").val() == '' || $("#dlistEntFed").val() == '0' || $("#dlistRol").val() == '0' ||  $("#txtUsuario").val() == '' ||  $("#txtContrasena").val() == '' ){

						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'Debe completar los campos con requeridos(*)'
						})

					}

					else{
						
						ejecutaPeticionAjaxGeneral("POST", "../../ConInserccion/insertarRegUsuarios", "formDatosRegUsuario","contenedorGeneral", "contenedorGeneral", "../../ConSeleccionador/CargaVistaRegUsuarios");
					}
					
	})	



		$("#btnCancelEditUsr").click(function(){

			ejecutaPeticionAjaxCargaSeccion("../../ConSeleccionador/CargaVistaRegUsuarios", "contenedorGeneral");


		})	



		function EditarUsuario($idUsuario){
	    	var idUsr = $idUsuario;

	    	ejecutaPeticionAjaxCargaSeccion("../../ConSeleccionador/ObtenerDatosUsuario/"+idUsr, "respuesta")

	    }

	    function BajaUsuario($idUsuario){
	    	var idUsr = $idUsuario;

	    	ejecutaPeticionAjaxActualizaDato("POST","../../ConActualizar/bajaUsuario/"+idUsr, "contenedorGeneral", "contenedorGeneral", "../../ConSeleccionador/CargaVistaRegUsuarios")

	    }





</script>