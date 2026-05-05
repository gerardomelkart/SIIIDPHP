<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title></title>


	 <style>

	 	.table-container {
            max-width: 60%;
            
        }

	 	
	 </style>


</head>
<body>


	<div class="card mt-3" style="border:none; background-color: #fff; ">


	
		<p class="card-header text-white font-weight-bold text-left" style="background: #98989A; font-size: 20px;"><i class="fa fa-search"></i> Reporte de Cargas por Estado </p>


			<div class="card mt-5" style="border:none; background-color: #fff; ">
				<p class="card-header text-white font-weight-bold text-left" id="titulo" style="background: #691C32;"> </p>


				<div class="card-body" id="body">

					<div class="table-container">
						<table id="tablaRptCargas" class="table display nowrap table-hover table-bordered" >

							<thead>
								<tr style="font-size: 12px; background: #691C32; color: #fff;">
									<th>Entidad Federativa</th>
									<th>Mes Corte</th>
									<th>Intentos</th>
									<th>Último Intento</th>
									<th>Cargas</th>
									<th>Última carga</th>
								</tr>
							</thead>
							<tbody>
							<!-- aca igual basarse en la otra tabla -->

							</tbody>
						</table>
				    </div>
				</div>
			</div>	

	</div>


</body>
</html>


<script>
        window.scrollTo(0, 0); // Desplaza la página al inicio (x=0, y=0) 

        //SCRIPT PARA DATATABLE
        $(document).ready(function() {
            var table = $('#tablaRptCargas').DataTable({
                language: {
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                responsive: true,
                scrollX: false,
                pageLength: 16, 
                lengthChange: false,
                scrollY: '450px',
                scrollCollapse: true,
                paging: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        filename: 'ReporteCargaEstados', // Nombre asignado al archivo exportado
                        title: 'Estatus de Carga por Estado' // Título dentro del archivo Excel 
                    }
                ]
            });

        });
    </script>