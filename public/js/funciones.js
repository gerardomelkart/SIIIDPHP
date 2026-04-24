

//CARGA SECCION
function ejecutaPeticionAjaxCargaSeccion(urlPeticion,idSeccion){
	//var esperar = 2000
	$.ajax({
		url:urlPeticion,
		beforeSend: function(){
			$("#"+idSeccion).html("<img width='80' src='../../public/img/load.gif'><p>Cargando ...</p>")
		},
		success: function(data){
			
			$("#"+idSeccion).html(data)
			
		}

	})
}








//CARGA SECCION CON ID
function ejecutaPeticionAjaxCargaSeccionID(tipoMetodo,urlPeticion,idSeccion){
	//var esperar = 2000
	$.ajax({
		type:tipoMetodo,
		url:urlPeticion,
		beforeSend: function(){
			$("#"+idSeccion).html("<img width='80' src='../../public/img/load.gif'><p>Cargando ...</p>")
		},
		success: function(data){
			
			$("#"+idSeccion).html(data)
		}
	})
}





//CERRAR SESION
function ejecutaPeticionAjaxCierraSesion(tipoMetodo,urlPeticion){
	
	 
	$.ajax({
		type:tipoMetodo,
		url:urlPeticion,
		beforeSend: function () {
			var customElement   =  
							
				   $("<div >", {
					   css     : {
						   "font-size" : "50px",
						   "margin-top" : "55px",
						   "color": "#000"
					   },
					   text    : 'Cerrando sesión...'
				   });
				   $.LoadingOverlay("show", {
					  custom  : customElement
			 });
		},
		success: function (data) {

			 $.LoadingOverlay("hide");
			 
			 if(data.message == 'Ok'){
			    window.location.href = "../../";
			 }else{
				window.location.href = "./../ConAcceso";
			 }
			
		 }
	});
}


//INICIAR SESION
function ejecutaPeticionAjaxGenericaLogin(tipoMetodo,urlPeticion,divResultado,divLoader,idBoton,idFormulario,mensajeLoader){
	
	 var dataString = $("#"+idFormulario).serialize();
  	
	 $.ajax({
		     type:tipoMetodo,
             url:urlPeticion,
		 	 data:dataString,
         beforeSend: function () {
				var customElement   =  
							
						$("<div >", {
							css     : {
								"font-size" : "50px",
								"margin-top" : "55px",
								"color": "#000"
							},
							text    : 'Validando Usuario...'
						});
						$.LoadingOverlay("show", {
						custom  : customElement
				});
			},
	     success: function (data) {
						if(data.message == 'Ok'){
							window.location.href = "../../ConAcceso/";
						}else if(data.message == 'Usuario o contrasena incorrecto'){
							$.LoadingOverlay("hide");
						
							Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Usuario o contraseña incorrecto!'
                            })
						}
	      }
     });
}






//FUNCION PARA CARGA DE ARCHIVO
function ejecutaPeticionAjaxUploadFiles(tipoMetodo, urlPeticion, divResultado, idFormulario, sobreescribir = 0) {
	const formData = new FormData($("#" + idFormulario)[0]);
	formData.append("sobreescribir", sobreescribir);

	$.ajax({
		type: tipoMetodo,
		url: urlPeticion,
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		beforeSend: function () {
			$.LoadingOverlay("show", {
				custom: $("<div>", {
					css: {
						"font-size": "50px",
						"margin-top": "55px",
						"color": "#000"
					},
					text: 'Procesando...'
				})
			});
		},
		success: function (response) {
			$.LoadingOverlay("hide");

			// Intentamos parsear como JSON si es string
			if (typeof response === 'string') {
				try {
					response = JSON.parse(response);
				} catch (e) {
					// No era JSON, asumimos que es HTML
					$("#" + divResultado).html(response);
					return;
				}
			}

			// Si es JSON y tiene la estructura esperada
			if (typeof response === 'object' && response.status !== undefined) {
				if (response.status === true) {
					$("#" + divResultado).html(response.html || '');
				} else if (response.status === 'existe_registro') {
					Swal.fire({
						title: 'Advertencia',
						text: 'Ya existen registros previos. ¿Desea eliminarlos?',
						icon: 'warning',
						showCancelButton: true,
						confirmButtonText: 'Sí, eliminar',
						cancelButtonText: 'No'
					}).then((result) => {
						if (result.isConfirmed) {
							// Reintentar con sobreescribir = 1
							ejecutaPeticionAjaxUploadFiles(tipoMetodo, urlPeticion, divResultado, idFormulario, 1);
						}
					});
				} else {
					Swal.fire('Error', response.msg || 'Ocurrió un error inesperado.', 'error');
				}
			} else {
				// Si no se reconoce la estructura, mostramos directamente
				$("#" + divResultado).html(response);
			}
		},
		error: function (xhr) {
			$.LoadingOverlay("hide");
			console.error(xhr.responseText);
			Swal.fire('Error', 'Fallo en la petición al servidor.', 'error');
		}
	});
}






//ACTUALIZAR DATOS 
function ejecutaPeticionAjaxActualizaDato(tipoMetodo,urlPeticion,divResultado,divRecarga,urlRecarga){

	//var dataString = $("#"+idFormulario).serialize();

	$.ajax({
		type:tipoMetodo,
		url:urlPeticion,
		//data:dataString,
		beforeSend: function () {
			$("#"+divResultado).html("<div align='center'><img width='80' src='../../public/img/load.gif'><p style='color#fff;'>Cargando ...</p></div>")
		},
		success: function (data) {
			$("#"+divResultado).html(data)
			$("#"+divRecarga).load(urlRecarga)
			

		}

	})
}





//ACTUALIZAR FORMULARIO
function ejecutaPeticionAjaxGeneral(tipoMetodo,urlPeticion,idFormulario,divResultado,divRecarga,urlRecarga){

	var dataString = $("#"+idFormulario).serialize();

    
	$.ajax({
		type:tipoMetodo,
		url:urlPeticion,
		data:dataString,
		beforeSend: function () {
			$("#"+divResultado).html("<div align='center'><img width='80' src='../../public/img/load.gif'><p style='color#fff;'>Cargando ...</p></div>")
		},
		success: function (data) {
			$("#"+divResultado).html(data)
			$("#"+divRecarga).load(urlRecarga)
			

		}

	})
}








