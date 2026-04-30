<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>

	<style>
		
		.contenedor{
			display: flex; 
			justify-content: center; 
			align-items: center; 
			gap: 0px; /* Espacio entre las tablas */

		}

		.descargas{
			display: flex; 
			justify-content: center; 
			align-items: center; 
			gap: 60px; /* Espacio entre las tablas */
			
		}

		.lbldescargas{
			display: flex; 
			justify-content: center; 
			align-items: center; 
			gap: 90px; /* Espacio entre las tablas */
			height: 110px; /* alto del div */
			
		}

		.formUploadFiles{
			box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5); /* Sombreado exterior */
		}

		.formDownloadplantillas{
			box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5); /* Sombreado exterior */
		}

		.imagen-descarga {
		    transition: transform 0.3s ease; /* Suaviza la animación */
		    display: inline-block; /* Necesario para que funcione transform */
		}

		.imagen-descarga:hover {
		    transform: scale(1.1); /* Aumenta tamaño en 10% */
		    cursor: pointer; /* Cambia el cursor a mano */
		}

		/* Opcional: Efecto adicional en el botón completo */
		.boton-descarga:hover {
		    opacity: 0.9; /* Ligera transparencia al pasar el mouse */
		}


	</style>



</head>
<body>

	<div class='contenedor'>

	  <div class="col-md-8">	

		<div class="card mt-3" style="border:none; background-color: #fff; ">

            <p class="card-header text-white font-weight-bold text-left" id="titulo" style="background: #98989A; font-size: 20px;">
                <span class="icon-desaparecidos-header">
                    <i class="fa fa-user"></i>
                    <i class="fa fa-circle-question icon-overlay-header"></i>
                </span>
                    Carga de información, de Desaparecidos
            </p>
			
				<form id="formUploadFiles" class="formUploadFiles" enctype="multipart/form-data">

					<div class="row">

					    

						<div class="col-5">

							
							<br>
							<br>
							<div class="row text-left" style="margin-left: 20px;">
								<div class="col">
										<label style="font-weight: bold; font-style: italic;"><span class="text-danger font-weight-bold">*</span> Seleccionar Archivo Expedientes:</label>
										<input type="file" id="FilesCSV1" name="file1" accept=".csv,.xlsx" style="margin-left: 50px;" > <br>

										<label style="font-weight: bold; font-style: italic;"><span class="text-danger font-weight-bold">*</span> Seleccionar Archivo Delitos:</label>
										<input type="file" id="FilesCSV2" name="file2" accept=".csv,.xlsx" style="margin-left: 50px;" >

										<label style="font-weight: bold; font-style: italic;"><span class="text-danger font-weight-bold">*</span> Seleccionar Archivo Victimas:</label>
										<input type="file" id="FilesCSV3" name="file3" accept=".csv,.xlsx" style="margin-left: 50px;" >
								</div>
							</div>
							
							

							<br>
							<div class="row text-left" style="margin-left: 30px;">
								<div class="col">
									<div class="form-group">
										<button  type="button" id="botonGuarda" class="btn boton btn-sm" ><i class="fa fa-paper-plane-o" aria-hidden="true"></i>Cargar Archivos</button>
									</div>
								</div>
							</div>

						</div>

					</div>						    
			    </form> 
		</div>
	  </div>

	  <div class="col-md-4">

	  		<div class="card " style="border:none; background-color: #fff;">

				<p class="card-header text-white font-weight-bold text-left" id="titulo" style="background: #98989A; font-size: 20px;"><i class="fa fa-file-excel"></i>  Descargar Plantillas</p>
			<form class="formDownloadplantillas">	
				<div class="row" >
					<div class="col">
						<div></div><br>
						<div class="container">
							<div class="row text-center justify-content-center">

								<div class="col-12 col-sm-6 col-md-4 mb-3">
									<a href="../public/Documentos/plantillas/ExpedientesDesaparecidos.xlsx"
									download="ExpedientesDesaparecidos.xlsx"
									title="Descargar Plantilla Expedientes">
									<img src="../public/img/logo_XLSX.png" class="img-fluid" style="max-height: 80px;" alt="Plantilla Carpetas">
								</a>
								<div><label>Carpetas</label></div>
							</div>

							<div class="col-12 col-sm-6 col-md-4 mb-3">
								<a href="../public/Documentos/plantillas/DelitosDesaparecidos.xlsx"
								download="DelitosDesaparecidos.xlsx"
								title="Descargar Plantilla Delitos">
								<img src="../public/img/logo_XLSX.png" class="img-fluid" style="max-height: 80px;" alt="Plantilla Delitos">
							</a>
							<div><label>Delitos</label></div>
						</div>

						<div class="col-12 col-sm-6 col-md-4 mb-3">
							<a href="../public/Documentos/plantillas/VictimasDesaparecidos.xlsx"
							download="VictimasDesaparecidos.xlsx"
							title="Descargar Plantilla Victimas">
							<img src="../public/img/logo_XLSX.png" class="img-fluid" style="max-height: 80px;" alt="Plantilla Victimas">
						</a>
						<div><label>Víctimas</label></div>
					</div>

				</div>
			</div>

		</div>
	</div>
			</form>
			</div>	

	  </div>	


	</div>

</body>
</html>




<script>

	window.scrollTo(0, 0); // Desplaza la página al inicio (x=0, y=0) 

 	$("#botonGuarda").click(function()
    {

        alert("Función de carga de archivos aún no implementada. Por favor, contacte al administrador.");

 		// if (  $("#FilesCSV1").val() == '' || $("#FilesCSV2").val() == '' || $("#FilesCSV3").val() == '' ) {

		// 					Swal.fire({
		// 						icon: 'error',
		// 						title: 'Error...',
		// 						text: 'Es necesario seleccionar los archivos a cargar'
		// 					})

		// 				}

		// else if (  $("#FilesCSV1").val() != '' &&  $("#FilesCSV2").val() != '' &&  $("#FilesCSV3").val() != ''  ){
		// 	var proceso = 'CargaInfo';
		//     ejecutaPeticionAjaxUploadFiles("POST", "../../ConUploadFiles/verUploads/"+proceso, "contenedorGeneral", "formUploadFiles")
		   
	       
		// }		

    }) 


 </script>