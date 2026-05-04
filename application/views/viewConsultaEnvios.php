<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	
	<title></title>
</head>
<body>


	<div class="card mt-3" style="border:none; background-color: #fff; ">


	
		<p class="card-header text-white font-weight-bold text-left" id="titulo" style="background: #98989A; font-size: 20px;"><i class="fa fa-search"></i> Consulta Envios </p>


				<div class="card mt-5" style="border:none; background-color: #fff; ">
			<p class="card-header text-white font-weight-bold text-left" id="titulo" style="background: #691C32;"> </p>


			<div class="card-body" id="body">

				<table id="tblConsultaEnvios" class="table display nowrap table-hover table-bordered" style="width:100%">

					<thead>
						<tr style="font-size: 12px; background: #691C32; color: #fff;">
							<th>Entidad Federativa</th>
							<th>Cve. Entidad</th>
							<th>Fecha de Envío</th>
							<th>Corte</th>
							<th>Usuario Envío</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>

					  <?php

						foreach ($tablaConsultaEnvioss as $dato){

					 ?>  
							<tr style="font-size: 11px;">
								<td><?php echo $dato->nom_ent; ?></td>
								<td><?php echo $dato->cve_estado; ?></td>
								<td><?php echo $dato->fcha_insert; ?></td>
								<td><?php echo $dato->mes_corte; ?></td>
								<td><?php echo $dato->usuario_envio; ?></td>
								 <td>
									

									  <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Consultar y descargar Acuse" onclick="verAcuse('<?php echo $dato->codigo_referencia; ?>')" ><i class="fa fa-file-pdf" aria-hidden="true"></i></button>


									  <a href='../../ConExportar/generar_csv_ExpedientesEnviados/<?php echo $dato->codigo_referencia; ?>' class="btn btn-outline-success btn-sm" title="Descargar Registros Enviados"><i class="fa fa-file-excel" aria-hidden="true"></i></a>

									   

								</td>
							</tr>
						  <?php } ?>  

					</tbody>
				</table>
			</div>
		</div>	

	</div>


</body>
</html>

<script>
	
window.scrollTo(0, 0); // Desplaza la página al inicio (x=0, y=0) 

	//SCRIPT PARA DATATABLE
	$(document).ready(function() {


		var table = $('#tblConsultaEnvios').DataTable( {
			 pageLength: 10, // Valor inicial seleccionado
			language: {
				
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
	        lengthMenu: [5, 20, 50, 100], // Opciones del dropdown
	        pageLength: 10, // Registros iniciales por página
	        lengthChange: false, // Mostrar u ocultar el selector
	      
			buttons: [ 'copy', 

						{
			                extend: 'excel',
			                filename: 'ReporteEnvios', 
			                title: 'Reporte de Envíos' 
			            }
			 ]

		} );

		table.buttons().container()
		.appendTo( '#tblConsultaEnvios_wrapper .col-md-6:eq(0)' );
	} );





	function verAcuse($cod_ref){

			var v_codRef =  $cod_ref;
			var v_proceso = 'CargaInfo'; 
            
	     ejecutaPeticionAjaxCargaSeccion('../../ConSeleccionador/abreModalAcuseEnvio/?cod_ref=' + encodeURIComponent(v_codRef)+ '&proceso=' + encodeURIComponent(v_proceso), 'contenedorGeneral3');
	   }


</script>