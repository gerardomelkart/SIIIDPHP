<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="stylesheet" href="../public/css/styleMenu.css"> -->
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
	<script src="../public/js/funciones.js"></script>
	<script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
	<script src="../public/js/loadingoverlay.js"></script>


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="../public/css/bootstrap.css">
	<link rel="stylesheet" href="../public/css/bootstrap.min.css">



	<title></title>

    <style>
        /* Asegura que el modal utilice toda la altura de la ventana */
        .modal-dialog {
            max-width: 90vw;
            margin: 0 auto;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .modal-content {
            height: 95vh; 
            display: flex;
            flex-direction: column;
        }

        .modal-body {
            flex: 1;
            overflow: hidden;
            padding: 0; 
            display: flex;
            flex-direction: column;
        }

        /* Asegura que el iframe use todo el espacio disponible */
        #iframePDF {
            flex: 1;
            width: 100%;
            border: none;
        }
    </style>
</head>




<body>

      

<?php
    
    header('Content-Type: text/html; charset=UTF-8');
   $this->load->view("viewHeader");
   $this->load->view("viewMenuLateral");
?>


    <main class="text-center">
        <div id="contenedorGeneral" style="padding: 120px 30px 0px 350px;">
        </div>

        <div id="contenedorGeneral2" style="padding: 0px 0px 0px 340px;">
        </div>

        <div id="contenedorGeneral3" style="padding: 0px 0px 0px 340px;">
        </div>
    </main>

</body>

</html>


<!-- MODAL PARA MOSTRAR ACUSE DE ENVIO DE INFORMACION AL INSERTAR LOS REGISTROS-->
    <div class="modal fade" id="modalAcuseEnvio" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" >
            <div class="modal-content">
                <div class="modal-header" style="background:#691c32; color:#FFFFFF">
                    <h4 id="txtHeadermodalAcuseEnvio" class="modal-title">Acuse de entrega de información</h4>
                    <button id="btnCerrarmodalAcuseEnvio" type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
                </div>
                <div class="modal-body">

                    <!-- Elementos para mostrar los datos. recibimos el valor del parametro en id="codigo" -->
                    <p style="display: none">Código de referencia: <span id="codigo" style="display: none"></span></p>
                    <p style="display: none">Tipo de Proceso: <span id="proceso" style="display: none"></span></p>

                     <div id="muestramodalAcuseEnvio"> 
                        <!-- <iframe id="iframePDF" src="../ConSeleccionador/createPDF/" width="100%" height="800"></iframe> -->
                        <iframe id="iframePDF"  width="100%" style="border:none;"></iframe>
                     </div>
                     <div class="row justify-content-around" id="divPDFBot">
                         
                     </div>
                </div>
            </div>
        </div>
    </div>   


    <script>

        v1 = '';
        v2 = '';

        $(document).ready(function() {
            $('#modalAcuseEnvio').on('shown.bs.modal', function () {
                // Obtener el valor del span id="codigo"
                var codigo = $('#codigo').text();
                var proceso = $('#proceso').text();
                v1 = codigo;
                v2 = proceso;
                
                // Construye la URL con los parámetros
                //var url = `../ConSeleccionador/createPDF/?codigo=${encodeURIComponent(codigo)}`;
                var url = `../ConSeleccionador/createPDF/?codigo=${encodeURIComponent(codigo)}&proceso=${encodeURIComponent(proceso)}`;
                
                // Actualiza el src del iframe
                $('#iframePDF').attr('src', url);
            });
        });


        function rechazarCarga(codigo,proceso,ctrl = 0){
            $.get("../ConUploadFiles/rechazarDatos", {
                codigo: codigo,
                proceso: proceso
            }, function(respuesta) {
                if(respuesta.includes('Success')){
                    if(ctrl = 0){
                            Swal.fire({
                            icon: 'error',
                            title: '¡Registros eliminados!',
                            showConfirmButton: true,
                        }).then((result) => {
                          if (result.isConfirmed) {
                            window.location.href = '/conAcceso/'; // Cambia a la ruta que necesites
                          }
                        });
                    }else{
                        console.log('Registros eliminados');
                    }
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Contacte al administrador.',
                        showConfirmButton: true,
                    });
                }
                if(ctrl == 0){
                    $("#divPDFBot").html('<div class="col-md-4" style="height:8vh"><button type="button" class="btn btn-danger btn-lg w-100 p-3" data-dismiss="modal">Cerrar</button></div>');
                }
            });
        }


        function aceptarCarga(codigo, proceso) {

            const btnAceptar = document.getElementById('btnAceptar');
            if (btnAceptar) {
                btnAceptar.disabled = true;
                btnRechazar.disabled = true;
                btnAceptar.innerHTML = `
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="d-flex align-items-center">
                                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                                <span>Procesando...</span>
                                            </div>
                                            <div class="progress mt-2 w-100" style="height: 2px; background-color: rgba(0,0,0,0.2);">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                                     style="width: 100%; background-color: #fff;">
                                                </div>
                                            </div>
                                        </div>
                                    `;
                btnAceptar.classList.remove('btn-success');
                btnAceptar.classList.add('btn-secondary');
                btnRechazar.classList.remove('btn-danger');
                btnRechazar.classList.add('btn-secondary');
            }

            let anio = $("#dlistAnioCorte").val()||'0';
            let mes = $("#dlistMesCorte").val()||'0';
            $.get("../ConUploadFiles/cargarDatos", {
                codigo: codigo,
                proceso: proceso,
                anio: anio,
                mes: mes
            }, function(respuesta) {
                if(respuesta.includes('Success')){
                    Swal.fire({
                        icon: 'success',
                        title: '¡Carga completada!',
                        showConfirmButton: true,
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Contacte al administrador.',
                        showConfirmButton: true,
                    });
                }
                var url = `../ConSeleccionador/createPDF/?codigo=${encodeURIComponent(codigo)}&proceso=${encodeURIComponent(proceso)}`;
                
                $('#iframePDF').attr('src', url);
                $("#divPDFBot").html('<div class="col-md-4" style="height:8vh"><button type="button" class="btn btn-danger btn-lg w-100 p-3" data-dismiss="modal">Cerrar</button></div>');

            });
        }



        function ajustarAlturaIframe() {
            const ventanaAlto = window.innerHeight;
            const headerAlto = $('.modal-header').outerHeight() || 60;
            const footerAlto = $('#divPDFBot').outerHeight() || 60;
            const espacioDisponible = ventanaAlto - headerAlto - footerAlto - 80;

            $('#iframePDF').css('height', espacioDisponible + 'px');
        }


        $('#modalAcuseEnvio').on('hidden.bs.modal', function () {
            var codigo = v1;
            var proceso = v2;
            rechazarCarga(codigo,proceso,1);
            $('#iframePDF').attr('src', '');
            $('#divPDFBot').empty();
        });
        

        $('#modalAcuseEnvio').on('show.bs.modal', function () {
            ajustarAlturaIframe();
        });



 /*************VALIA 10 MINUTOS DE INACTIVIDAD Y CIERRA LA SESION REGRESANDO A LA PAGINA DE LOGIN ************/
        var inactivityTime = function () {
        var time;
        // Tiempo en milisegundos (10 minutos)
        var maxInactivity = 10 * 60 * 1000;

        function logout() {
            // petición AJAX para cerrar la sesión
            ejecutaPeticionAjaxCierraSesion("POST","../../ConAutenticacion/cerrarSesion/"); 

        }

        // Resetea el temporizador en cada evento
        window.onload = resetTimer;
        document.onmousemove = resetTimer;
        document.onkeydown = resetTimer;
        document.onclick = resetTimer;
        document.onscroll = resetTimer;

        function resetTimer() {
            clearTimeout(time);
            time = setTimeout(logout, maxInactivity);
        }
    };

    inactivityTime();



       
    </script>    


