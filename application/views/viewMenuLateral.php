
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../public/css/styleMenuLateral.css">
    <script src="../public/js/funciones.js"></script>
   
    <script src="../public/js/jquery.min.js"></script>
    <script src="../public/js/loadingoverlay.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="../public/js/bootstrap.js"></script>
    <script src="../public/libs/Chart.min.js"></script>

   

    <!-- CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">



<!-- JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script> 
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script> <!-- librerias para el boton de imprmir en las tablas  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> <!-- librerias para el boton de excel en las tablas  -->



<!-- estilos para modulo de desaparecidos, se podria mover despues a un archivo css para mantener el orden y limpieza del codigo, pero por ahora lo dejo aqui para que se apliquen los estilos de inmediato al cargar el menu lateral, ya que es un modulo nuevo y no quiero que se me olvide agregarlo al css despues. -->
<style>

#menu-desaparecidos .nav-item,
#menu-incidencia .nav-item {
    display: block;
    width: 100%;
}

#menu-desaparecidos .nav-link,
#menu-incidencia .nav-link {
    display: flex;
    align-items: center;
}

#menu-desaparecidos.collapsing,
#menu-incidencia.collapsing {
    transition: height 0.18s ease-in-out !important;
}

/* Mantiene estable el icono con overlay */
.icon-menu {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    position: relative;
    width: 20px;
    margin-right: 4px;
}

/* Badges (?, upload, refresh) */
.icon-badge-question,
.icon-badge-upload,
.icon-badge-refresh {
    position: absolute;
    right: -2px;
    bottom: -2px;
    font-size: 8px;
}

/* Suaviza la animación del collapse */
.collapse {
    transition: height 0.2s ease;
}

.nav-link,
.nav-link i,
.nav-link span {
    cursor: pointer;
}

</style>






    <title></title>



<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <div class="profile-sidebar">
        <div class="profile-userpic">
            <img src="../public/img/logoMujBandera.png" class="img-fluid" alt="Foto de perfil">
        </div>
        <div class="profile-usertitle">
            <div class="profile-usertitle-name"><?php echo $this->session->nombre .' '. $this->session->apellidop .' '. $this->session->apellidom ; ?></div>
            <div class="profile-usertitle-status"><span class="indicator label-success"></span>En línea</div>
            <div style="text-align: right;"><span class="indicator label-success"></span>Ver. 2.1</div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="divider"></div>

<?php  if($this->session->rol == 1) { ?> 


    <ul class="nav flex-column">


<!-- Modulo incidencia delictiva -->        


<?php if($this->session->HabCargaInfo == 1 || $this->session->HabModifInfo == 1): ?>
<li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#menu-incidencia">
        <i class="fa fa-folder"></i> Incidencia Delictiva
        <i class="fa fa-plus float-right"></i>
    </a>

    <ul class="nav flex-column collapse" id="menu-incidencia">

        <?php if($this->session->HabCargaInfo == 1): ?>
            <li class="nav-item">
                <a id="btnIrEnviarInf" class="nav-link">
                    <i class="fa fa-upload"></i> Integrar Información
                </a>
            </li>
        <?php endif; ?>

        <?php if($this->session->HabModifInfo == 1): ?>
            <li class="nav-item">
                <a id="btnIrActualizarInf" class="nav-link">
                    <i class="fa fa-refresh"></i> Actualizar Información
                </a>
            </li>
        <?php endif; ?>

    </ul>
</li>
<?php endif; ?>



<!-- modulo de desaparecidos -->
<?php  if($this->session->HabModuloDesaparecidos == 1) { ?> 
<li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#menu-desaparecidos">
        <span class="fa-stack icon-menu">
            <i class="fa fa-user fa-stack-1x"></i>
            <i class="fa fa-circle-question icon-badge-question"></i>
        </span>
        Desaparecidos
        <i class="fa fa-plus float-right"></i>
    </a>

    <ul class="nav flex-column collapse" id="menu-desaparecidos">
        <li class="nav-item">
            <a id="btnCargaDesaparecidos" class="nav-link">
                <span class="fa-stack icon-menu">
                    <i class="fa fa-user fa-stack-1x"></i>
                    <i class="fa fa-upload icon-badge-upload"></i>
                </span>
                Carga Desaparecidos
            </a>
        </li>

        <li class="nav-item">
            <a id="btnActualizaDesaparecidos" class="nav-link">
                <span class="fa-stack icon-menu">
                    <i class="fa fa-user fa-stack-1x"></i>
                    <i class="fa fa-refresh icon-badge-refresh"></i>
                </span>
                Actualizar Desaparecidos
            </a>
        </li>
    </ul>
</li>
<?php  } ?>


        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#menu-informes">
                <i class="fa fa-navicon"></i> Informes <i class="fa fa-plus float-right"></i>
            </a>
            <ul class="nav flex-column collapse" id="menu-informes">
                <li class="nav-item"><a id="btnConsultaEnvios" class="nav-link" ><i class="fa fa-arrow-right"></i> Consultar Envíos</a></li>
            </ul>
            <ul class="nav flex-column collapse" id="menu-informes">
                <li class="nav-item"><a id="btnReporteCargas" class="nav-link" ><i class="fa fa-arrow-right"></i> Reporte de Cargas</a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#menu-catalogos">
                <i class="fa fa-book"></i> Catálogos <i class="fa fa-plus float-right"></i>
            </a>
            <ul class="nav flex-column collapse" id="menu-catalogos">
                <li class="nav-item"><a id="btnIrRegUsuarios" class="nav-link" style="cursor:pointer;"><i class="fa fa-arrow-right"></i> Usuarios</a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a id="btnConfiguracion" class="nav-link" style="cursor:pointer;"><i class="fa fa-cogs"></i> Configuración</a>
        </li>
        <li class="nav-item">
            <a id="btnCerrarSesion" class="nav-link" style="cursor:pointer;"><i class="fa fa-power-off"></i> Cerrar Sesión</a>
        </li>
    </ul>


    
<?php  } ?>

<?php  if($this->session->rol == 2) { ?>


    <ul class="nav flex-column">


 <!-- Verificar si esta habilitada la opcion para la carga-->      
<?php  if($this->session->HabCargaInfo == 1) {  ?>
        <li class="nav-item">
                <a id="btnIrEnviarInf" class="nav-link" style="cursor:pointer;"><i class="fa fa-upload"></i> Integrar Información</a>
        </li>
<?php  }  ?>     

 <!-- Verificar si esta habilitada la opcion para actualizaciones o modificaciones-->        
<?php  if($this->session->HabModifInfo == 1) { ?> 
        <li class="nav-item">
                <a id="btnIrActualizarInf" class="nav-link" style="cursor:pointer;"><i class="fa fa-refresh"></i> Actualizar Información</a>
        </li>
<?php  }  ?>        

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#menu-informes">
                <i class="fa fa-navicon"></i> Informes <i class="fa fa-plus float-right"></i>
            </a>
            <ul class="nav flex-column collapse" id="menu-informes">
                <li class="nav-item"><a id="btnConsultaEnvios" class="nav-link" ><i class="fa fa-arrow-right"></i> Consultar Envíos</a></li>
            </ul>
        </li>


        <li class="nav-item">
            <a id="btnCerrarSesion" class="nav-link" style="cursor:pointer;"><i class="fa fa-power-off"></i> Cerrar Sesión</a>
        </li>
    </ul>
<?php  } ?>

<?php  if($this->session->rol == 3) { ?>


    <ul class="nav flex-column">   

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#menu-informes">
                <i class="fa fa-navicon"></i> Informes <i class="fa fa-plus float-right"></i>
            </a>
            <ul class="nav flex-column collapse" id="menu-informes">
                <li class="nav-item"><a id="btnConsultaEnvios" class="nav-link" ><i class="fa fa-arrow-right"></i> Consultar Envíos</a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a id="btnCerrarSesion" class="nav-link" style="cursor:pointer;"><i class="fa fa-power-off"></i> Cerrar Sesión</a>
        </li>
    </ul>
<?php  } ?>



</div>




<script>

    $(document).ready(function() {

    });
    

    /*PETICION  PARA OPCION DE ENVIAR O CARGAR REGISTROS perfil:Operador*/
    $("#btnIrEnviarInf").click(function(){

        ejecutaPeticionAjaxCargaSeccion("../../ConSeleccionador/CargaVistaEnviarInf", "contenedorGeneral");
    }) 

    /*PETICION  PARA OPCION PARA ACTUALIZAR INFORMACION perfil:administrador,Operador*/
    $("#btnIrActualizarInf").click(function(){

        ejecutaPeticionAjaxCargaSeccion("../../ConSeleccionador/CargaVistaActualizarInf", "contenedorGeneral");
    }) 
    













    /*PETICION  PARA OPCION DE CONSULTAR ENVIOS Y REIMPRIMIR ACUSE perfil: Administrador(todos) y Operador(solo sus registros)*/
    $("#btnConsultaEnvios").click(function(){

        ejecutaPeticionAjaxCargaSeccion("../../ConSeleccionador/CargaVistaConsultaEnvios", "contenedorGeneral");
    }) 

    
    /*PETICION  PARA OPCION DE CONSULTAR REPORTE DE CARGAS POR ESTADO: Administrador*/
    $("#btnReporteCargas").click(function(){

        ejecutaPeticionAjaxCargaSeccion("../../ConSeleccionador/CargaVistaReporteCargas", "contenedorGeneral");
    }) 


     /*PETICION  PARA CARGAR OPCION DE REGISTRO DE USUARIOS perfil:Administrador*/
    $("#btnIrRegUsuarios").click(function(){

        ejecutaPeticionAjaxCargaSeccion("../../ConSeleccionador/CargaVistaRegUsuarios", "contenedorGeneral");

        document.getElementById("contenedorGeneral2").innerHTML = "";  //limpia el contenido del div "contenedorGeneral2"

    }) 

    
    /*PETICION  PARA CARGAR OPCION DE CONFIGURACION perfil:Administrador*/
    $("#btnConfiguracion").click(function(){

        ejecutaPeticionAjaxCargaSeccion("../../ConSeleccionador/CargaVistaConfiguracion", "contenedorGeneral");

    }) 


    /*PETICION  PARA CERRAR SESION*/
     $("#btnCerrarSesion").click(function(){

         ejecutaPeticionAjaxCierraSesion("POST","../../ConAutenticacion/cerrarSesion/"); 
     }) 




</script>