<style>
.custom-checkbox {
  padding: 1rem; /* Espaciado interno */
  border-radius: 8px; /* Bordes redondeados */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.25); /* Sombra suave */
  transition: all 0.3s ease; /* Transición para efectos hover */
}

.custom-checkbox:hover {
  box-shadow: 0 6px 8px rgba(0, 0, 0, 0.35); /* Sombra más pronunciada al pasar el mouse */
}

.form-check-label {
  font-size: 1.2rem !important; /* Tamaño de letra más grande */
  margin-left: 0.8rem; /* Espacio entre checkbox y texto */
}

.form-check-input {
  width: 1.5rem; /* Ancho del checkbox */
  height: 1.5rem; /* Alto del checkbox */
  margin-top: 0.15rem; /* Alineación vertical */
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25); /* Sombra en el checkbox */
}

/* Opcional: Cambiar color cuando está seleccionado */
.form-check-input:checked {
  background-color: #0d6efd;
  border-color: #0d6efd;
}
</style>


<div class="card mt-3" style="border:none; background-color: #fff; ">

	
	<p class="card-header text-white font-weight-bold text-left" id="titulo" style="background: #98989A; font-size: 20px;"><i class="fa fa-cogs"></i> Configuración </p>

	<div class="card-body" id="body">
		<div class="row text-left mb-2">
			<div class="col-md-6">
				<span class="text-left text-danger font-weight-bold" style="font-size: 13px;">Seleccione la(s) opcion(es) segun se requiera.</span>
			</div>
		</div>

		<hr>

		<form id="formDatosAdminConfig">

		
				<div class="row text-left">
					<div class="col-md-6">
						<div class="form-check">
						    <input class="form-check-input" type="checkbox" value="" id="chkHabCargaInfo"  name="chkHabCargaInfo" <?php 
    							if( $valoresConfig[0]->hab_carga_info == 1) { 
								        echo 'checked="checked"'; 
								    } 
								?>>
						    <label class="form-check-label" for="chkHabCargaInfo"> 
						        Habilitar módulo para la carga de información
						    </label>
						</div>
					</div>
				</div>

				<div class="row text-left">
					<div class="col-md-6">
						<div class="form-check">
						    <input class="form-check-input" type="checkbox" value="" id="chkHabModifInfo" name="chkHabModifInfo" <?php 
    							if( $valoresConfig[0]->hab_modifica_info == 1) { 
								        echo 'checked="checked"'; 
								    } 
								?>>
						    <label class="form-check-label" for="chkHabModifInfo"> 
						        Habilitar módulo para actualizaciones de información
						    </label>
						</div>
					</div>
				</div>

				<div class="row text-left">
					<div class="col-md-6">
						<div class="form-check">
						    <input class="form-check-input" type="checkbox" value="" id="chkHabDesaparecidosInfo" name="chkHabDesaparecidosInfo" <?php 
    							if( $valoresConfig[0]->hab_modulo_desaparecidos == 1) { 
								        echo 'checked="checked"'; 
								    } 
								?>>
						    <label class="form-check-label" for="chkHabDesaparecidosInfo"> 
						        Habilitar módulo de desaparecidos
						    </label>
						</div>
					</div>
				</div>





		

			<br>	
			<div class="row">
				<div class="col-md-6 text-left">
					<div class="form-group">
						<button  type="button" id="btnGuardarConfiguracion" class="btn boton btn-sm"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Guardar</button>
					</div>
				</div>
			</div>

		</form>	


  		<div id="respuesta"></div> 


  	</div>
</div>		




<script>

	window.scrollTo(0, 0); // Desplaza la página al inicio (x=0, y=0) 

	$("#btnGuardarConfiguracion").click(function(){


		   var chkHabCargaInfo = $("#chkHabCargaInfo").is(":checked") ? 1 : 0;
		   var chkHabModifInfo = $("#chkHabModifInfo").is(":checked") ? 1 : 0;
		   var chkHabDesaparecidosInfo = $("#chkHabDesaparecidosInfo").is(":checked") ? 1 : 0;


			ejecutaPeticionAjaxCargaSeccionID("POST","../../ConActualizar/AdminConfig/" +chkHabCargaInfo +'/' +chkHabModifInfo +'/' +chkHabDesaparecidosInfo, "contenedorGeneral")

		    ejecutaPeticionAjaxCargaSeccion("../../ConSeleccionador/CargaVistaConfiguracion","contenedorGeneral");

						
	})




</script>