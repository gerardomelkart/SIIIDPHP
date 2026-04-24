
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

 

    <title></title>




    <style>

    nav{
       margin-top: 50px;
       height: 90px;
       background-color:#235B4E;
       text-align: center;
     }

     nav ul{
        list-style: none;
        display: inline-block;
        padding:18px;
     }

     nav ul li{
         float: left;
         margin-top: 20px;
     }

     nav ul li a {
         color: white;
         font-weight: bold;
         text-decoration: none;
         font-size: 20px;
         padding: 18px;
     }

     

    .linea{
      background-color: #BC955C;
      height: 10px;
      }

</style>


</head>
<body>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="public/js/funciones.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>



</body>
</html>


 


<div >


	 <?php
		$this->load->view("viewHeader");
	?> 
	
</div>



<nav>
   <ul>
   	 <li><a id="btnIrInicio" style="cursor:pointer; color: white;  " >Inicio</a></li>	
     <li><a id="btnIrIntegrarInformacion" style="cursor:pointer; color: white;  " >Integrar Información</a></li>
   </ul>
 </nav>


<div class='row linea'>
  <div class="col-md-12 linea "><font style=" color: #691C32"></font></div>
</div>




<main class="text-center">
    <div id="contenedorGeneral" style="padding: 30px 30px 30px 30px; background:#F7F7F7;" >

           

    </div> 
</main>








<script>
	
	  /*PETICION AJAX PARA OPCION DE inicio*/
      $("#btnIrInicio").click(function(){
          ejecutaPeticionAjaxCargaSeccion("../../integracionSCNI/ConSeleccionador/CargaVistaInicio", "contenedorGeneral");
      }) 


     /*PETICION AJAX PARA OPCION DE GENERAR FORMATO DE PAGO*/
     $("#btnIrIntegrarInformacion").click(function(){
         ejecutaPeticionAjaxCargaSeccion("../../integracionSCNI/ConSeleccionador/CargaVistaIntegracion", "contenedorGeneral");
     }) 

   
  




</script>

