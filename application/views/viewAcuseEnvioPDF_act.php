<?php

    //TRAER LOGOS
$header  = "public/img/imgEncabezadoAcuse.png";
$imagenBase64_header = "data:image/png;base64," . base64_encode(file_get_contents($header));

$footer  = "public/img/imgPieAcuse.png";
$imagenBase64_footer = "data:image/png;base64," . base64_encode(file_get_contents($footer));

$imgFondo  = "public/img/ImgFondo.png";
$imagenBase64_fondo = "data:image/png;base64," . base64_encode(file_get_contents($imgFondo));


date_default_timezone_set('America/Mexico_City');

$anioActual = date("Y");
$mesActual = date("n");
$diaActual = date("j");
//$diaActualSem = date("w");
$arrMes = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
//$arrDia = array('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo');
$fecha = $diaActual.' de '.$arrMes[$mesActual-1].' de '.$anioActual;

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>

    <style>
        body{ 
            margin: 0;
            padding: 0;
            line-height: 1;
            display: inline-block;
            background-image:url('<?php echo $imgFondo; ?>');
        }

        .texto-sin-espacios {
            margin: 0;
            padding: 0;
            line-height: 1;
            display: inline-block;
        }

        .tblResumenEnvioReg{
          border-collapse: collapse; /* Colapsa los bordes de las celdas */
          width: 100%; /* ancho completo del contenedor */
        }

        .tblResumenDelitos{
          border-collapse: collapse; /* Colapsa los bordes de las celdas */
          width: 100%; /* ancho completo del contenedor */
        }

        #titulo {
            margin-bottom: 0;
        }

        .card-header{
            display: flex;
            align-items: center;
            justify-content: center;
            height: 30px;
            white-space: nowrap; /* Evita que el texto se envuelva */
            color: #fff;
            font-weight: bold;
            text-align: center;
            background-color: #691C32;
            border: none;
            font-size: 20px;
        }

        .tdDesc{
             border: 1px solid black; 
             font-size: 17px;
        }

        th {
          border: 1px solid black;
          background-color: #a8a6a6; /* Color de fondo gris para encabezados */
          text-align: center; /* Centra el texto en los encabezados */
          font-size: 17px; /* Tamaño de fuente de 16 píxeles para encabezados */
        }

        tr:nth-child(even) {
          background-color: #f9f9f9; /* Color de fondo gris muy claro para filas pares */
        }

    </style>

</head>
<body>


    <div>
        
        <table style=" border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;" >
            <tr>
                <td style="text-align: center; vertical-align: middle;">
                    <img style="width: 720px; height: 110px;" src="<?php echo $imagenBase64_header; ?>">
                </td>
                
            </tr>   
        </table>

        <table cellspacing="0" cellpadding="0" width="100%" border="0">
            <tr>
                <td style=" text-align:right;  width:720px;">
                    <br>
                    <span class="texto-sin-espacios"><b>SECRETARIADO EJECUTIVO DEL SISTEMA</b></span><br>
                    <span class="texto-sin-espacios"><b>NACIONAL DE SEGURIDAD PÚBLICA</b></span><br>
                    <span class="texto-sin-espacios"><b>CENTRO NACIONAL DE INFORMACIÓN</b></span><br><br>
                    <span class="texto-sin-espacios" style="font-size: 16px; margin-left: 351px; text-align: justify; font-family: sans-serif;">
                    Ciudad de México a <?php echo $dataInfAcuse_Act[0]->fecha_de_envio; ?></span>
                </td>
            </tr> 
        </table>

        <table>
            <tr>
                <td style=" text-align:center;  width:720px;" >
                    <br><br><br>
                    <span class="texto-sin-espacios" style="font-size: 20px;"><b>ACUSE DE ACTUALIZACION DE INFORMACIÓN</b></span><br>
                </td>
            </tr>  
        </table>

        <br><br><br>
        <table>
            <tr>
                <td>
                    <p style="text-align: justify; font-size: 15px; font-family: sans-serif;">
                        Mediante este documento, se confirma que la información proporcionada ha sido enviada de manera satisfactoria a través de nuestra plataforma web. Queda así registrada su recepción formal, garantizando que los datos ingresados han sido recibidos y procesados conforme a los protocolos establecidos. Para cualquier consulta o verificación posterior, este acuse servirá como constancia válida del envío realizado por parte de la entidad de <b><?php echo $dataInfAcuse_Act[0]->DESC_ESTADO; ?></b>, el día <b><?php echo $dataInfAcuse_Act[0]->fecha_de_envio; ?></b>, a las <b><?php echo $dataInfAcuse_Act[0]->hora_de_envio; ?></b> horas. 
                    </p>
                     <p style="font-size:15px; font-family: sans-serif;">Periodo de Actualización: <b><?php echo $dataInfAcuse_Act[0]->mes_corte; ?></b>  <b><?php echo $dataInfAcuse_Act[0]->anio_corte; ?></b> </p>
                   
                </td>
            </tr>
        </table>


        <div class="card mt-5">
                <p class="card-header text-white font-weight-bold text-left" id="titulo">Detalle de registros actualización de información:</p>
                <table class="tblResumenEnvioReg">
                  <thead>
                    <tr style="text-align: center;">
                      <th>Descripcion</th>
                      <th>Total Registros Antes</th>
                      <th>Total Registros Actualizados</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="tdDesc" style="padding-left:30px;">Expedientes:</td>
                      <td class="tdDesc" style="text-align: center;"><?php echo $dataInfAcuse_RegAnt[0]->TotReg_carpetas_hist; ?></td>
                      <td class="tdDesc" style="text-align: center;"><?php echo $dataInfAcuse_Act[0]->TotReg_carpetas; ?></td>
                    </tr>
                    <tr>
                      <td class="tdDesc" style="padding-left:30px;">Delitos:</td>
                      <td class="tdDesc" style="text-align: center;"><?php echo $dataInfAcuse_RegAnt[0]->TotReg_delitos_hist; ?></td>
                      <td class="tdDesc" style="text-align: center;"><?php echo $dataInfAcuse_Act[0]->TotReg_delitos; ?></td>
                    </tr>
                    <tr>
                      <td class="tdDesc" style="padding-left:30px;">Victimas:</td>
                      <td class="tdDesc" style="text-align: center;"><?php echo $dataInfAcuse_RegAnt[0]->TotReg_victimas_hist; ?></td>
                      <td class="tdDesc" style="text-align: center;"><?php echo $dataInfAcuse_Act[0]->TotReg_victimas; ?></td>
                    </tr> 
                  </tbody>
                </table>            
        </div>

        <table id="tblResumenDelitos" border="1"  class="tblResumenDelitos" style="width:100%">
              <thead>
                <tr style="text-align: center;">
                  <th>Clave</th>
                  <th>Modalidad Delito</th>
                  <th>Grado Consumación</th>
                  <th>Total Delitos</th>
                  <th>Total Victimas</th>
                </tr>
              </thead>
              <tbody>
                    <?php
                        foreach ($tablaConteoDelitos as $dato){

                          ?>
                          <tr style="font-size: 11px;">
                            <td><?php echo $dato->clave4; ?></td>
                            <td><?php echo $dato->modalidad_delito; ?></td>
                            <td><?php echo $dato->grado_cons; ?></td>
                            <td align="center"><?php echo $dato->tot_delitos; ?></td>
                            <td align="center"><?php echo $dato->tot_victimas; ?></td> 
                          </tr>
                      <?php } ?>
              </tbody>
          </table>

          <table class="" border="0">
              <thead>
              </thead>
              <tbody>
                <tr>
                  <td class="" style="padding-left:488px;">Total:</td>
                  <td class="" style="text-align: center; width:84px; "><?php echo $dataInfAcuse_Act[0]->TotReg_delitos; ?></td>
                  <td class="" style="text-align: center; width:91px; "><?php echo $dataInfAcuse_Act[0]->TotReg_victimas; ?></td>
                </tr>
              </tbody>
         </table>
        

        <table>
            <tr>
                <td>
                    <p style="text-align: justify; font-size: 15px; font-family: sans-serif;">
                        Agradecemos su colaboración y quedamos a disposición para cualquier requerimiento adicional.
                    </p>
                </td>
            </tr>
        </table>



        <table style="position: fixed; bottom: 50; left: 0; width: 100%; border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;">
            <tr>
                <td style="text-align: center; vertical-align: middle;">
                    <img style="width: 720px; height: 110px;" src="<?php echo $imagenBase64_footer; ?>">
                </td>
            </tr>
        </table>








    </div>    

    



    
 
</body>
</html>