<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(APPPATH . 'libraries/PhpSpreadsheet/autoload.php');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Settings;




// CODIFICACION
	function codificarUTF8(array $data): array{
		$resultado = [];
		foreach($data as $clave => $valor){
			if(!mb_check_encoding($valor,'UTF-8')){
				$valor=mb_convert_encoding($valor,'UTF-8','Windows-1252');
			}
			$resultado[$clave] = $valor;
		}
		return $resultado;
	}


Class ConUploadFiles extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		//cargar modelo indicado
		$this->load->library('session');
		$this->load->library('upload');
		$this->load->model('ModSeleccionarDatos');
		$this->load->model('ModInserccionDatos');
		$this->load->model('ModEliminarDatos');
		//$this->load->model('ModActualizaDatos');

		

	}


	


	public function CargaVistaInicio(){
	
		$this->load->view("viewContenidoInicio");
	}


	public function verUploads($proceso = null)
	{
	    $usuario_sesion = $this->session->usuario;
	    $sobreescribir   = $this->input->post('sobreescribir');

	    if (!$proceso) {
	        echo json_encode([
	            'status' => false,
	            'msg' => 'No se especificó proceso'
	        ]);
	        return;
	    }

	    if ($proceso === 'CargaInfo') {
	        $existe = $this->ModSeleccionarDatos->consultaPeriodoCarga($usuario_sesion);

	        if ($existe && $existe->ExisteRegistro > 0) {
	            if ($sobreescribir != 1) {
	                echo json_encode(['status' => 'existe_registro']);
	                return;
	            }
	        }
	    }

	    // Ejecutar Uploads()
	    $html = $this->Uploads($proceso);

	    if($html && $html != ''){
	    	echo json_encode([
	        'status' => true,
	        'html'   => $html
	    ]);
	    }
	}




	public function Uploads($proceso){

		log_message('debug',">>> ENTRÓ A LA FUNCIÓN Uploads");

		foreach ($_FILES as $key => $file) {
		    log_message('debug',"Archivo recibido [$key]: tamaño = {$file['size']} bytes, nombre = {$file['name']}");
		}


		$arregloFormulario = $this->input->post();

		if($proceso=='Actualizaciones'){ // si es una actualizacion o modificacion, recibimos los valores del año y mes de corte
			$anioCorte	= $arregloFormulario['dlistAnioCorte'];
			$mesCorte = $arregloFormulario['dlistMesCorte'];
			$this->session->set_userdata('anio_corte', $anioCorte);
    		$this->session->set_userdata('mes_corte', $mesCorte);
		}else{
			$anioCorte	= '';
			$mesCorte = '';
		}

			
			$config['upload_path'] = "public/Documentos/tmpCSV";
			$config['max_size'] = "20480"; //20Mb
			$config['max_filename']="35";
            $config['remove_spaces']="true";
			$config['allowed_types'] = 'csv|xlsx';	
			$this->upload->initialize($config);	



			$archivos = ['file1', 'file2', 'file3'];
			$resultado = [];

			foreach ($archivos as $campo) {
			    if (!$this->upload->do_upload($campo)) {
			        $error = 'Error en ' . $campo . ': ' . $this->upload->display_errors();
			        log_message('error', $error); // opcional: registro en logs
			        $this->session->set_flashdata('error', $error);
			        return "<div class='alert alert-danger'>Error en el archivo $campo: $error</div>";
			    }

				$archivoSubido = $this->upload->data();

				$csvProcesado = $this->xlsx2csv($archivoSubido);

				if (!$csvProcesado) {
				    log_message('error', 'Error al convertir archivo a CSV: ' . $archivoSubido['file_name']);
				    $this->session->set_flashdata('error', 'Error al convertir archivo ' . $archivoSubido['file_name']);
				    return "<div class='alert alert-danger'>Error al convertir archivo: {$archivoSubido['file_name']}</div>";
				}

				$csvProcesado['original_path'] = $archivoSubido['full_path'];
				

			    array_push($resultado, $csvProcesado);
			}



            // Archivos que subimos al servidor y mandamos a validar su estructura
			$file1 = $resultado[0];
			$file2 = $resultado[1];
			$file3 = $resultado[2];
		    $archivos = [$file1, $file2, $file3];




		    //1. Validar estructura de archivos
		    // validamos los 3 archivos y regresamos true o flse de cada archivo, los resultados los guardamos en un arreglo
		    foreach ($archivos as $archivo) {	
		      
		      $resultadoValidacion[] =  $this->validaEstructura($archivo['full_path'], $archivo['file_name']);
		     

		    }


		    // Recorremos los resultados del arreglo para validar si todos fueron true, es decir que los 3 archivos estan correctos

		    $todosCorrectos = 'correcto';
		    foreach ($resultadoValidacion as $valor) {
			    if ($valor == false) { 
			        $todosCorrectos = 'incorrecto';
			         
			    }
			}


			if ($todosCorrectos == 'correcto') {
			    

				$codigoRef = uniqid(); // creamos Un ID único para referencia de los registros enviados
			    //Leer CSV
	            $data1 = $this->read_csv($file1['full_path'], $codigoRef, $proceso, $anioCorte, $mesCorte);
	            $data2 = $this->read_csv($file2['full_path'], $codigoRef, $proceso, $anioCorte, $mesCorte);
	            $data3 = $this->read_csv($file3['full_path'], $codigoRef, $proceso, $anioCorte, $mesCorte);

	            // Guardar en sesión
	            $this->session->set_userdata('csv_data', [
	                'data1' => $data1,
	                'data2' => $data2,
	                'data3' => $data3,
	                'file1_path' => $file1['full_path'],
	                'file2_path' => $file2['full_path'],
	                'file3_path' => $file3['full_path']
	            ]);

		            // Mostrar datos  PRUEBA
		            // $this->load->view('viewDatosFiles', [
		            //     'dataTblCarpetas' => $data1,
		            //     'dataTblDelitos' => $data2
		            // ]);

            $this->insert_tmp($codigoRef,$proceso,$anioCorte,$mesCorte);  //llama a la funcion para insertar los datos de los archivos a las tablas temporales



			} else { // en caso de que algun arcchivo este incorrecto, borramos del repositorio "tmpCSV" los 3 archivos que se cargaron
			    foreach ($archivos as $archivo) {
			    	log_message('debug', 'Ruta completa del archivo: ' . $archivo['full_path']);
			    	//unlink($archivo['full_path']);
			    	//unlink($archivo['original_path']);
			    }
			    
			}
                    
    }


    private function validaEstructura($path, $nameArch){

    	// Leer encabezados del CSV
	    $csv = fopen($path, 'r');
	    $headersArch = fgetcsv($csv); // Primera fila como encabezados
	    $sbtr_nomArchivo = substr($nameArch,10,5);
		$table_columns = null;

	    if ($sbtr_nomArchivo == "carpe") {
	        $table_name = 'tmp_carpetas';
	        $table_columns = $this->ModSeleccionarDatos->get_table_columns($table_name);
	    } elseif ($sbtr_nomArchivo == "delit") {
	        $table_name = 'tmp_delitos';
	        $table_columns = $this->ModSeleccionarDatos->get_table_columns($table_name);
	    } elseif ($sbtr_nomArchivo == "victi") {
	        $table_name = 'tmp_victimas';
	        $table_columns = $this->ModSeleccionarDatos->get_table_columns($table_name);
	    } else {
	        echo "<script>
	            Swal.fire({
	                icon: 'error',
	                title: 'Archivo no reconocido',
	                text: 'El nombre del archivo $nameArch no corresponde con ningún tipo esperado.'
	            });
	        </script>";
	        return false;
	    }
	    	
	  
	    
	    // Validar número de columnas
	    if (count($headersArch) !== count($table_columns)) {  // si no coinciden

	    	$totCamposArchivo = count($headersArch);
	    	$totCamposTabla = count($table_columns);

	    	echo "<script>
					Swal.fire(
					'Error',
					'El Archivo a cargar contiene $totCamposArchivo columnas, pero la tabla  requiere de $totCamposTabla columnas, favor de corregir.' ,
					'error'
					)
					</script>";
			log_message('debug','File: '.$nameArch.'////////////////////////////////');
			log_message('debug','Headers: '.json_encode($headersArch).' Archivo: '.json_encode($table_columns));
	         return false;
	    }

	    else {  // si el total de columnas coincide, ahora validamos los nombres de las columnas

		    // Extraer nombres de columnas de la tabla MySQL en un arreglo
			$dbColumns = array();
			foreach ($table_columns as $col) {
			    $dbColumns[] = $col->COLUMN_NAME;
			}

			// Paso 2: Convertir ambos arrays a minúsculas para normalizar
			$csvHeaders = array_map('strtolower', $headersArch);
			$dbHeaders = array_map('strtolower', $dbColumns);

			// Paso 3: Comparar
			if ($csvHeaders === $dbHeaders) { //si coinciden los nombres entonces ya insertamos a las tablas temporales
			   
			    return true;

			} else {
			    // Encontrar diferencias
			    $enCSVNoBD = array_diff($csvHeaders, $dbHeaders);
			    //$enBDNoCSV = array_diff($dbHeaders, $csvHeaders);

			    
			    if (!empty($enCSVNoBD)) {


				    echo "<script>
				        Swal.fire({
				            icon: 'error',
				            title: 'Error...',
				            html: 'Se identificaron inconsistencias en los siguientes campos: <strong>' + 
				                  '" . implode("<br>", $enCSVNoBD) . "' + 
				                  '</strong>, favor de verificar los nombres de los campos de acuerdo a la plantilla. <br><br> Error en la estructura del archivo: <strong>' + 
				                  '" . $nameArch . "' + 
				                  '</strong>'
				        });
				    </script>";

				    return false;
				}
			}	



	}


    //print_r($headersArch);
    //print_r($table_columns);

    }



    // private function read_csv($path, $codigoRef) {

    // 	$usuario_sesion = $this->session->usuario;
    // 	$codigoReferencia = $codigoRef; // Un ID único para referencia
    // 	$fecha = new DateTime();
	// 	// Restar 1 mes
	// 	$fecha->modify('-1 month');
	// 	$mes_anterior = $fecha->format('n');
	// 	$anio_actual =  $fecha->format('Y'); //(ej. 2024)

    //     $data = [];
    //     if (($handle = fopen($path, 'r')) !== FALSE) {
    //         while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
    //         	$row['usuario_reg'] = $usuario_sesion;  //agregar el dato usuario de session
    //         	$row['fcha_insert'] = date("Y-m-d H:i:s");  //agregar la fecha del sistema
    //         	$row['codigo_referencia'] = $codigoReferencia;  //agregar un codigo unico para referencia
    //         	$row['mes_corte'] = $mes_anterior;  //mes inmediato anterior
    //         	$row['anio_corte'] = $anio_actual;  //año actual
    //             //$data[] = $row;
    //             mb_convert_encoding($data[] = $row,  'UTF-8', 'ISO-8859-1');
    //         }
    //         fclose($handle);
    //     }
    //     return $data;
    // }


    private function read_csv($path, $codigoRef, $proceso, $anioCorte, $mesCorte) {
	    $usuario_sesion = $this->session->usuario;
	    $codigoReferencia = $codigoRef;
	    $fecha = new DateTime();
	    $fecha->modify('-1 month');
	    $mes_anterior = $fecha->format('n');
	    $anio_actual = $fecha->format('Y');

	    $data = [];
	    if (($handle = fopen($path, 'r')) !== FALSE) {
	        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
	            // Convertir cada campo a UTF-8
	            foreach ($row as &$field) {
	                $field = $field;
	            }
	            unset($field); // Romper la referencia

	          

	            if($proceso == 'CargaInfo'){ // si es una carga nueva, insertamos el año año actual  y mes inmediato anterior

	            	date_default_timezone_set('America/Mexico_City');	
		              // Agregar campos adicionales como array asociativo
		              $data[] = array_merge(
		                $row,
		                [
		                    'usuario_reg' => $usuario_sesion,
		                    'fcha_insert' => date("Y-m-d H:i:s"),
		                    'codigo_referencia' => $codigoReferencia,
		                    'mes_corte' => $mes_anterior,
		                    'anio_corte' => $anio_actual
		                ]
		            );

	            }

	            if($proceso == 'Actualizaciones'){  // si es una actualización, recuperamos el año y mes de corte que teniamos para insertar ese mismo dato en las tablas ya que es un reemplazo de información

	            	date_default_timezone_set('America/Mexico_City');	
	            	// Agregar campos adicionales como array asociativo
		              $data[] = array_merge(
		                $row,
		                [
		                    'usuario_reg' => $usuario_sesion,
		                    'fcha_insert' => date("Y-m-d H:i:s"),
		                    'codigo_referencia' => $codigoReferencia,
		                    'mes_corte' => $mesCorte,
		                    'anio_corte' => $anioCorte
		                ]
		            );


	            	
	            }


	            





	        }
	        fclose($handle);
	    }
	    return $data;
	}




    public function insert_tmp($codigoRef,$proceso,$anioCorte,$mesCorte) {
        // Obtener datos de sesión
        $csv_data = $this->session->userdata('csv_data');
        $codigoReferencia = $codigoRef;


        
        if (!$csv_data) {
            show_error('No hay datos para insertar');
        }

        // Procesar inserción
        $this->db->trans_start();


        $this->db->query("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
        //$this->db->query("SET CHARACTER SET utf8");
        
        // Insertar tabla 1 (saltar encabezado)
        $headers1 = array_shift($csv_data['data1']);
        $headers1['usuario_reg'] = 'usuario_reg'; //agregar la columna 'usuario_reg' a la tabla de carpetas
        $headers1['fcha_insert'] = 'fcha_insert'; //agregar la columna 'fcha_insert' a la tabla de carpetas
        $headers1['codigo_referencia'] = 'codigo_referencia'; //agregar la columna 'codigo_referencia' a la tabla de carpetas
        $headers1['mes_corte'] = 'mes_corte'; //agregar la columna 'mes_corte' a la tabla de carpetas
        $headers1['anio_corte'] = 'anio_corte'; //agregar la columna 'anio_corte' a la tabla de carpetas
        $i = 1;
		foreach ($csv_data['data1'] as $row) {
		    if (count($headers1) !== count($row)) {
		        log_message('error', "❗ Desalineación en fila $i");
		        log_message('error', '➤ Headers (' . count($headers1) . '): ' . json_encode($headers1));
		        log_message('error', '➤ Row     (' . count($row) . '): ' . json_encode($row));
		    } else {
		        log_message('debug', "✔ Fila $i bien alineada");
		    }

		    $insert_data = @array_combine($headers1, $row); // usar @ para evitar error fatal
		    if ($insert_data === false) {
		        log_message('error', "❌ array_combine falló en fila $i");
		        continue;
		    }

		    $insert_data_utf = codificarUTF8($insert_data);
		    $this->db->insert('tmp_carpetas', $insert_data_utf);

		    $i++;
		}

        // Insertar tabla 2 (saltar encabezado)
        $headers2 = array_shift($csv_data['data2']);
        $headers2['usuario_reg'] = 'usuario_reg'; //agregar la columna 'usuario_reg' a la tabla de delitos
        $headers2['fcha_insert'] = 'fcha_insert'; //agregar la columna 'fcha_insert' a la tabla de delitos
        $headers2['codigo_referencia'] = 'codigo_referencia'; //agregar la columna 'codigo_referencia' a la tabla de delitos
        $headers2['mes_corte'] = 'mes_corte'; //agregar la columna 'mes_corte' a la tabla de delitos
        $headers2['anio_corte'] = 'anio_corte'; //agregar la columna 'anio_corte' a la tabla de delitos
        foreach ($csv_data['data2'] as $row) {
            $insert_data = array_combine($headers2, $row);
            // CODIFICACION
            $insert_data_utf=codificarUTF8($insert_data);
            $this->db->insert('tmp_delitos', $insert_data_utf);
        }

        // Insertar tabla 3 (saltar encabezado)
        $headers3 = array_shift($csv_data['data3']);
        $headers3['usuario_reg'] = 'usuario_reg'; //agregar la columna 'usuario_reg' a la tabla de delitos
        $headers3['fcha_insert'] = 'fcha_insert'; //agregar la columna 'fcha_insert' a la tabla de delitos
        $headers3['codigo_referencia'] = 'codigo_referencia'; //agregar la columna 'codigo_referencia' a la tabla de delitos
        $headers3['mes_corte'] = 'mes_corte'; //agregar la columna 'mes_corte' a la tabla de delitos
        $headers3['anio_corte'] = 'anio_corte'; //agregar la columna 'anio_corte' a la tabla de delitos
        foreach ($csv_data['data3'] as $row) {
            $insert_data = array_combine($headers3, $row);
            // CODIFICACION
            $insert_data_utf=codificarUTF8($insert_data);
            $this->db->insert('tmp_victimas', $insert_data_utf);
        }

        $this->db->trans_complete();

        // //mover los archivos a la carpeta de respaldosCSV
		// $destination_folder = "public/Documentos/respaldosCSV/";

		// $new_path1 =  $destination_folder . $codigoReferencia .'_'. basename($csv_data['file1_path']);
		// $new_path2 =  $destination_folder . $codigoReferencia .'_'. basename($csv_data['file2_path']);
		// $new_path3 =  $destination_folder . $codigoReferencia .'_'. basename($csv_data['file3_path']);

		// rename($csv_data['file1_path'], $new_path1);
		// rename($csv_data['file2_path'], $new_path2);
		// rename($csv_data['file3_path'], $new_path3);


        // Limpiar. eliminar los archivos de la carpeta temporal despues de moverlosa la carpeta de respaldosCSV
	     //   @unlink($csv_data['file1_path']);
	      //  @unlink($csv_data['file2_path']);
	      //  @unlink($csv_data['file3_path']);
	      //  $this->session->unset_userdata('csv_data');

        if ($this->db->trans_status() === FALSE) {
            show_error('Error en la inserción');
        } else {

	        	$obtDatosValIntegridad = $this->ModSeleccionarDatos->ValidarIntegridadDatos($codigoReferencia);

	        	$estatus_resValInteg = 1;

	        	if(!empty($obtDatosValIntegridad)){

	        		$estatus_resValInteg = 0;

	        		echo "
		                <html>
						<head>
						    <meta charset='utf-8'>
						    <meta name='viewport' content='width=device-width, initial-scale=1'>
						    <script src='../public/js/funciones.js'></script>
						    <script src='../public/js/loadingoverlay.js'></script>
						    <title></title>

						<style>

							.contenedor {
							  display: flex; 
							  justify-content: center; 
							  align-items: center; 
							  gap: 20px; /* Espacio entre las tablas */
							}

							.txtareaMsj {
							    width: 610px;     
							    height: 150px;    
							    padding: 8px;
							    border: 1px solid #ccc;
							    resize: both;      
							    overflow: auto;    
							    text-align: left;
							    white-space: pre-wrap; 
							 }

							th, td {
							  border: 1px solid black; 
							  padding: 8px; 
							  text-align: left; 
							  font-size: 12px; 
							}

							th {
							  background-color: #a8a6a6; /* Color de fondo gris para encabezados */
							  text-align: center; /* Centra el texto en los encabezados */
							  font-size: 16px; 
							}

							tr:nth-child(even) {
							  background-color: #f9f9f9; /* Color de fondo gris muy claro para filas pares */
							}

							/* Sombreado */
							.txtareaMsj {
							  box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5); /* Sombreado exterior */
							}

							th, td {
							  box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); /* Sombreado interior */
							}

						</style>
						    

						</head>
						<body>

							<div class='contenedor'>

								<div class='card mt-5' style='border:none; background-color: #fff;'>
									<p class='card-header text-white font-weight-bold text-left' id='titulo' style='background: #691C32;''>Validación. Integridad referencial de registros</p>

									<div class='txtareaMsj' contenteditable='false' role='textbox'> Se identificaron inconsistencias en la integridad referencial entre los archivos. Cada carpeta debe tener al menos un delito asociado, y este a su vez, al menos una víctima asociada al delito. Favor de verificar, corregir y enviar nuevamente su información.
									</div>
										 

								</div>

							</div>	<!-- cierre del contenedor -->

							
						</body>
						</html>";	
	        		
	            } //fin validacion $obtDatosValIntegridad 


	        	$obtDatos = $this->ModSeleccionarDatos->ValidarDatosArchCarpetasInv($codigoReferencia, $proceso);
	        	$cod_ref = $obtDatos[0]->codigo_referencia;
	        	$usr_reg =  $obtDatos[0]->usuario_reg;
	        	$fcha_reg = $obtDatos[0]->fcha_insert;
	        	$mes_cte = $obtDatos[0]->mes_corte;
	        	$totReg = $obtDatos[0]->total_reg;
	        	$tot_id_ci_null = $obtDatos[0]->total_id_ci_null;
	        	$tot_id_ci_duplicados = $obtDatos[0]->total_id_ci_duplicados;
	        	$fha_ini_fra_rango = $obtDatos[0]->fecha_inicio_fra_rango;
	        	$tot_ntra_ci_null = $obtDatos[0]->total_ntra_ci_null;
	        	$tot_fha_de_ini_null = $obtDatos[0]->total_fha_de_ini_null;
	        	$tot_hra_de_ini_null = $obtDatos[0]->total_hra_de_ini_null;
	        	$format_fcha_incorrecta = $obtDatos[0]->formato_fcha_incorrecta;
	        	$Dato_dia_incorrecto = $obtDatos[0]->dia_incorrecto;
	        	$format_hra_incorrecta = $obtDatos[0]->formato_hra_incorrecta;
	        	$cve_tipoExp_incorrecta = $obtDatos[0]->cve_texp_incorrecta;
	        	$estatus_resVal_carpetas = $obtDatos[0]->estatus_rval_carpetas;

	        	$obtDatosDel = $this->ModSeleccionarDatos->ValidarDatosArchDelitos($codigoReferencia);
	        	$cod_refDel = $obtDatosDel[0]->codigo_referencia;
	        	$totRegDel = $obtDatosDel[0]->total_regDelitos;
	        	$tot_id_ci_del_null = $obtDatosDel[0]->total_id_ci_null;
	        	$tot_id_delito_null = $obtDatosDel[0]->total_id_delito_null;
	        	$tot_id_delito_duplicados = $obtDatosDel[0]->total_id_delito_duplicados;
	        	$tot_dto_null = $obtDatosDel[0]->total_dto_null;
	        	$tot_dto_prin_incorrecto = $obtDatosDel[0]->total_dto_prin_incorrecto;
	        	$tot_moda_dto_null = $obtDatosDel[0]->total_moda_dto_null;
	        /**	$tot_forma_acc_null = $obtDatosDel[0]->total_forma_acc_null;  SE ELIMINO  **/
	        //*	$tot_emto_com_dto_null = $obtDatosDel[0]->total_emto_com_dto_null;   SE ELIMINO  **/
	        //*	$tot_clasf_de_dto_null = $obtDatosDel[0]->total_clasf_de_dto_null;  SE ELIMINO **/
	        //*	$tot_id_mun_hchos_null = $obtDatosDel[0]->total_id_mun_hchos_null;  SE ELIMINO  **/
	        //*	$tot_id_col_hchos_null = $obtDatosDel[0]->total_id_col_hchos_null;  SE ELIMINO  **/
	            $tot_nom_ent_hchos_null = $obtDatosDel[0]->total_nom_ent_hchos_null;
	            $clave_ent_hchos_incorrecta = $obtDatosDel[0]->cve_ent_hchos_incorrecta;
	        	$clave_forma_acc_incorrecta = $obtDatosDel[0]->cve_forma_acc_incorrecta;
	        	$Exp_con_masdeuno_o_sin_dtoPrin = $obtDatosDel[0]->Exp_conmasdeuno_o_sin_dtoPrin;
	        	$tot_fcha_de_hchos_null = $obtDatosDel[0]->total_fha_de_hchos_null;
	        	$format_fchaHchos_incorrecta = $obtDatosDel[0]->formato_fchaHchos_incorrecta;
	            $fecha_hchos_incorrecta = $obtDatosDel[0]->fha_hchos_incorrecta;
	        	$dia_fuera_rango = $obtDatosDel[0]->dia_fra_rango;
	        	$long_fchaHchos_incorrecta = $obtDatosDel[0]->longitud_fchaHchos_incorrecta;
	        	$tot_hra_de_hchos_null = $obtDatosDel[0]->total_hra_de_hchos_null;
	        	$long_hraHchos_incorrecta = $obtDatosDel[0]->longitud_hraHchos_incorrecta;
	        	$clave_emto_com_dto_incorrecta = $obtDatosDel[0]->cve_emto_com_dto_incorrecta;
	        	$clave_grdo_cons_incorrecta = $obtDatosDel[0]->cve_grdo_cons_incorrecta;
	        	$cve_clasf_dto_incorrecta = $obtDatosDel[0]->cve_clasf_dto_incorrecta;
	        	$tot_nom_mun_hchos_null = $obtDatosDel[0]->total_nom_mun_hchos_null;
	        	$clave_mun_hchos_incorrecta = $obtDatosDel[0]->cve_mun_hchos_incorrecta;
	        	$tot_nom_col_hchos_null = $obtDatosDel[0]->total_nom_col_hchos_null;
	        	$clave_cp_incorrecta = $obtDatosDel[0]->cve_cp_incorrecta;
	        	$fmto_coord_x_incorrecto = $obtDatosDel[0]->formato_coord_x_incorrecto;
	        	$fmto_coord_y_incorrecto = $obtDatosDel[0]->formato_coord_y_incorrecto;
	        	/*$tot_coord_x_null = $obtDatosDel[0]->total_coord_y_null;*/
	        	/*$tot_coord_y_null = $obtDatosDel[0]->total_coord_y_null;*/
	        	$tot_dom_hchos_null = $obtDatosDel[0]->total_dom_hchos_null;
	        /*$mes_fuera_rango = $obtDatosDel[0]->mes_fra_rango; *****SE ELIMINO  ***/
	        	$estatus_resVal_delitos = $obtDatosDel[0]->estatus_rval_delitos;




	        	$obtDatosVict = $this->ModSeleccionarDatos->ValidarDatosArchVictimas($codigoReferencia);
	        	$cod_refVict = $obtDatosVict[0]->codigo_referencia;
	        	$totRegVictimas = $obtDatosVict[0]->total_regVictimas;
	        	$tot_id_ci_vict_null = $obtDatosVict[0]->total_id_ci_null;
	        	$tot_id_delito_vict_null = $obtDatosVict[0]->total_id_delito_null;
	        	$tot_id_vicf_null = $obtDatosVict[0]->total_id_vicf_null;
	        	$tot_id_vicf_duplicados = $obtDatosVict[0]->total_id_vicf_duplicados;
	       /** 	$tot_id_tv_null = $obtDatosVict[0]->total_id_tv_null;   SE ELIMINO  **/
	        	$clave_tv_incorrecto = $obtDatosVict[0]->cve_tv_incorrecto;
	        	$clave_id_tpm_incorrecta = $obtDatosVict[0]->cve_id_tpm_incorrecta;
	        	$tot_pob_null = $obtDatosVict[0]->total_pob_null;
	        	$tot_disc_incorrecto = $obtDatosVict[0]->total_disc_incorrecto;
	        	$format_fcha_nac_incorrecto = $obtDatosVict[0]->formato_fcha_nac_incorrecto;
	        	$clave_sexo_incorrecta = $obtDatosVict[0]->cve_sexo_incorrecta;
	        	$clave_genero_incorrecta = $obtDatosVict[0]->cve_genero_incorrecta;
	        	$clave_edad_incorrecto = $obtDatosVict[0]->cve_edad_incorrecto;
	        	$clave_nacionalidad_incorrecto = $obtDatosVict[0]->cve_nacionalidad_incorrecto;
	        	$clave_rel_vict_imputado_incorrecto = $obtDatosVict[0]->cve_rel_vict_imputado_incorrecto;
	        	$estatus_resVal_victimas = $obtDatosVict[0]->estatus_rval_victimas;


				

        	//si la información de alguno de los archivos cargados no cumple con los criterios de validación, borramos los registros de las tablas temporales ya que se tienen que volver a cargar
        	if($estatus_resVal_carpetas == 0 || $estatus_resVal_delitos == 0 || $estatus_resVal_victimas == 0 || $estatus_resValInteg == 0){
        		
        		//$this->ModEliminarDatos->EliminarDatos($cod_ref);

        		echo "<script>
						Swal.fire(
						'Error',
						'Se identificaron inconsistencias en la información las cuales se detallan en las tablas que se muestran a continuación, favor de corregir y cargarlos nuevamente.' ,
						'error'
						)
						</script>";
        	}

            echo "
                <html>
				<head>
				    <meta charset='utf-8'>
				    <meta name='viewport' content='width=device-width, initial-scale=1'>
				    <script src='../public/js/funciones.js'></script>
				    <script src='../public/js/loadingoverlay.js'></script>
				    <title></title>

				<style>

					.contenedor {
					  display: flex; /* Convierte el contenedor en un flexbox */
					  justify-content: center; /* Centra las tablas horizontalmente */
					  align-items: flex-start; /* Alinea elementos en la parte superior (vertical) */

					  gap: 20px; /* Espacio entre las tablas */
					}

					.tblCarpetas{
					  border-collapse: collapse; /* Colapsa los bordes de las celdas */
					  width: 100%; /* ancho completo del contenedor */
					}

					th, td {
					  border: 1px solid black; /* Borde de 1 píxel sólido negro */
					  padding: 8px; /* Espacio interno de 8 píxeles */
					  text-align: left; /* Alinea el texto a la izquierda */
					  font-size: 12px; /* Tamaño de fuente de 14 píxeles */
					}

					th {
					  background-color: #a8a6a6; /* Color de fondo gris para encabezados */
					  text-align: center; /* Centra el texto en los encabezados */
					  font-size: 16px; /* Tamaño de fuente de 16 píxeles para encabezados */
					}

					tr:nth-child(even) {
					  background-color: #f9f9f9; /* Color de fondo gris muy claro para filas pares */
					}

					/* Sombreado */
					.tblCarpetas {
					  box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5); /* Sombreado exterior */
					}

					th, td {
					  box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); /* Sombreado interior */
					}

					.msgValidacionMAL{
						text-align: left; /* Alinea el texto a la izquierda */
						font-weight: bold;
						font-size: 20px;
						Color: #9F2241;
					}

					.msgValidacionOK{
						text-align: left; /* Alinea el texto a la izquierda */
						font-weight: bold;
						font-size: 20px;
						Color: #235B4E;
					}

				</style>
				    

				</head>
				<body>

					<div class='contenedor'>

						<div class='card mt-5' style='border:none; background-color: #fff;'>
							<p class='card-header text-white font-weight-bold text-left' id='titulo' style='background: #691C32;'>Validación. Archivo Expedientes </p>
							<table class='tblCarpetas'>
							  <thead>
							    <tr style='text-align: center;'>
							      <th>Descripcion</th>
							      <th>Total Registros</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <td>Total de registros en el archivo de expedientes:</td>
							      <td style='text-align: center;'>$totReg </td>
							    </tr>";

							    if($tot_id_ci_null > 0){
							    	$inconsistencia = 'id_ci_sinDato';
							    	echo"
								    <tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                \"ID_CI\" sin información:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_id_ci_null</td>
								    </tr>
								    ";
							   }else{
							   		echo"
								    <tr>
								      <td>\"ID_CI\"  sin información:</td>
								      <td style='text-align: center;'>$tot_id_ci_null</td>
								    </tr>
								    ";
							   }
							   
							   if($tot_id_ci_duplicados > 0){
							   	    $inconsistencia = 'ID_CI_duplicados';
							    	echo"
								    <tr>
								       <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                \"ID_CI\" duplicados:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_id_ci_duplicados</td>
								    </tr>
								    ";
							   }else{
							   		echo"
								    <tr>
								      <td>\"ID_CI\" duplicados:</td>
								      <td style='text-align: center;'>$tot_id_ci_duplicados</td>
								    </tr>
								    ";
							   }

							   if($tot_ntra_ci_null > 0){
							   		$inconsistencia = 'nomenclatura_sinDato';
							    	echo"
								    <tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Falta la nomenclatura del expediente:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_ntra_ci_null</td>
								    </tr>
							    	";
							    } else {
							    	echo"
								    <tr>
								      <td>Falta la nomenclatura del expediente:</td>
								      <td style='text-align: center;'>$tot_ntra_ci_null</td>
								    </tr>
							    	";
							    }

							    if($tot_fha_de_ini_null > 0){
							    	$inconsistencia = 'fechaInicio_sinDato';
							    	echo"
							    	<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Falta la fecha de inicio:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_fha_de_ini_null</td>
								    </tr>
							    	";
							    }else{
							    	echo"
							    	<tr>
								      <td>Falta la fecha de inicio:</td>
								      <td style='text-align: center;'>$tot_fha_de_ini_null</td>
								    </tr>
							    	";
							    }

							    if($format_fcha_incorrecta > 0){
							    	$inconsistencia = 'fmto_fechaInicio_incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Fecha de inicio con formato incorrecto:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$format_fcha_incorrecta</td>
								    </tr>
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Fecha de inicio con formato incorrecto:</td>
								      <td style='text-align: center;'>$format_fcha_incorrecta</td>
								    </tr>
							   		";
							   }

							   if($Dato_dia_incorrecto > 0){
							   		$inconsistencia = 'dia_fechaInicio_incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Valor del día en la fecha de inicio incorrecto:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$Dato_dia_incorrecto</td>
								    </tr>
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Valor del día en la fecha de inicio incorrecto:</td>
								      <td style='text-align: center;'>$Dato_dia_incorrecto</td>
								    </tr>
							   		";
							   }

							   if($fha_ini_fra_rango > 0){
							   	    $inconsistencia = 'FHA_INI_fraRango';
							    	echo"
								    <tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Fecha de inicio fuera de rango:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$fha_ini_fra_rango</td>
								    </tr>
								    ";
							   }else{
							   		echo"
								    <tr>
								      <td>Fecha de inicio fuera de rango:</td>
								      <td style='text-align: center;'>$fha_ini_fra_rango</td>
								    </tr>
								    ";
							   }

							    if($tot_hra_de_ini_null > 0){
							    	$inconsistencia = 'hora_ini_sinDato';
							    	echo"
							    	<tr>
								      <td style='text-align: center;'>
							            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
							               style='display: inline-block; 
							                      padding: 6px 7px;
							                      color: #9F2241; 
							                      text-decoration: none; 
							                     '>
							               Falta la hora de inicio:
							            </a>
								      </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_hra_de_ini_null</td>
								    </tr>
							    	";
							    }else{
							    	echo"
							    	<tr>
								      <td>Falta la hora de inicio:</td>
								      <td style='text-align: center;'>$tot_hra_de_ini_null</td>
								    </tr>
							    	";
							    }

							    if($format_hra_incorrecta > 0){
							    	$inconsistencia = 'fmto_hra_ini_incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
							            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
							               style='display: inline-block; 
							                      padding: 6px 7px;
							                      color: #9F2241; 
							                      text-decoration: none; 
							                     '>
							               Hora de inicio con formato incorrecto:
							            </a>
								      </td>
								      <td style='text-align: center; Color: #9F2241;'>$format_hra_incorrecta</td>
								    </tr>
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Hora de inicio con formato incorrecto:</td>
								      <td style='text-align: center;'>$format_hra_incorrecta</td>
								    </tr>
							   		";
							   } 

							    if($cve_tipoExp_incorrecta > 0){
							    	$inconsistencia = 'cve_tipo_exp_incorrecto';
							    	echo"
							    	<tr>
								      <td style='text-align: center;'>
							            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
							               style='display: inline-block; 
							                      padding: 6px 7px;
							                      color: #9F2241; 
							                      text-decoration: none; 
							                     '>
							               Clave de tipo de expediente no válida según el catálogo:
							            </a>
								      </td>
								      <td style='text-align: center; Color: #9F2241;'>$cve_tipoExp_incorrecta</td>
								    </tr>
							    	";
							    }else{
							    	echo"
							    	<tr>
								      <td>Clave de tipo de expediente no válida según el catálogo:</td>
								      <td style='text-align: center;'>$cve_tipoExp_incorrecta</td>
								    </tr>
							    	";
							    } 
							    
							    
					    echo"   
							  </tbody>
							</table>			
						</div>

<!-- TABLA DELITOS  -->
							<div class='card mt-5' style='border:none; background-color: #fff;'>
							<p class='card-header text-white font-weight-bold text-left' id='titulo' style='background: #691C32;'>Validacion archivo Delitos </p>
							<table class='tblCarpetas'>
							  <thead>
							    <tr style='text-align: center;'>
							      <th>Descripcion</th>
							      <th>Total Registros</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <td>Total de registros en el archivo de delitos:</td>
							      <td style='text-align: center;'>$totRegDel </td>
							    </tr>";

							    if($tot_id_ci_del_null > 0){
							    	$inconsistencia = 'ID_CI_enDELITOS_null';
							    	echo"
								    <tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                \"ID_CI\"  sin información:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_id_ci_del_null</td>
								    </tr>
								    ";
							   }else{
							   		echo"
								    <tr>
								      <td>\"ID_CI\"  sin información:</td>
								      <td style='text-align: center;'>$tot_id_ci_del_null</td>
								    </tr>
								    ";
							   }

							    if($tot_id_delito_null > 0){
							    	$inconsistencia = 'ID_DELITO_null';
							    	echo"
								    <tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                \"ID_DELITO\"  sin información:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_id_delito_null</td>
								    </tr>
							    	";
							    } else {
							    	echo"
								    <tr>
								      <td>\"ID_DELITO\"  sin información:</td>
								      <td style='text-align: center;'>$tot_id_delito_null</td>
								    </tr>
							    	";
							    }
							    
							    if($tot_id_delito_duplicados > 0){
							    	$inconsistencia = 'ID_DELITO_duplicados';
							    	echo"
								    <tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                \"ID_DELITO\" duplicados:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_id_delito_duplicados</td>
								    </tr>
							    	";
							    } else {
							    	echo"
								    <tr>
								      <td>\"ID_DELITO\" duplicados:</td>
								      <td style='text-align: center;'>$tot_id_delito_duplicados</td>
								    </tr>
							    	";
							    }

							    if($tot_dto_null > 0){
							    	$inconsistencia = 'Desc_delito_null';
							    	echo"
							    	<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Falta la descripción del delito:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_dto_null</td>
								    </tr>
							    	";
							    }else{
							    	echo"
							    	<tr>
								      <td>Falta la descripción del delito:</td>
								      <td style='text-align: center;'>$tot_dto_null</td>
								    </tr>
							    	";
							    }

							    if($tot_dto_prin_incorrecto > 0){
							    	$inconsistencia = 'dto_principal_incorrecto';
							    	echo"
							    	<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                El delito principal no corresponde a los valores \"1\" o \"0\":
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_dto_prin_incorrecto</td>
								    </tr>
							    	";
							    }else{
							    	echo"
							    	<tr>
								      <td>El delito principal no corresponde a los valores \"1\" o \"0\":</td>
								      <td style='text-align: center;'>$tot_dto_prin_incorrecto</td>
								    </tr>
							    	";
							    }
							    
							    if($Exp_con_masdeuno_o_sin_dtoPrin > 0){
							    	$inconsistencia = 'CI_masdeuno_o_sin_dto_prin';
							    	echo"
								    <tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                El expediente carece de un delito principal o tiene más de uno:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$Exp_con_masdeuno_o_sin_dtoPrin</td>
								    </tr>
							    	";
							    } else {
							    	echo"
								    <tr>
								      <td>El expediente carece de un delito principal o tiene más de uno:</td>
								      <td style='text-align: center;'>$Exp_con_masdeuno_o_sin_dtoPrin</td>
								    </tr>
							    	";
							    }

							    if($tot_moda_dto_null > 0){
							    	$inconsistencia = 'Modalidad_dto_null';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Falta la descripción de la modalidad del delito:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_moda_dto_null</td>
								    </tr>
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Falta la descripción de la modalidad del delito:</td>
								      <td style='text-align: center;'>$tot_moda_dto_null</td>
								    </tr>
							   		";
							   } 

							   if($clave_forma_acc_incorrecta > 0){
							   	$inconsistencia = 'cve_formaAccionIncorrecta';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Clave de forma de acción del delito no válida según el catálogo:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$clave_forma_acc_incorrecta</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Clave de forma de acción del delito no válida según el catálogo:</td>
								      <td style='text-align: center;'>$clave_forma_acc_incorrecta</td>
								    </tr>	
							   		";
							   }

							   if($tot_fcha_de_hchos_null > 0){
							   	$inconsistencia = 'fcha_de_hchos_null';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Falta la fecha de hechos:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_fcha_de_hchos_null</td>
								    </tr>
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Falta la fecha de hechos:</td>
								      <td style='text-align: center;'>$tot_fcha_de_hchos_null</td>
								    </tr>
							   		";
							   } 

							   if($format_fchaHchos_incorrecta > 0){
							   	$inconsistencia = 'fcha_de_hchos_formatoIncorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Fecha de hechos con formato incorrecto:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$format_fchaHchos_incorrecta</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Fecha de hechos con formato incorrecto:</td>
								      <td style='text-align: center;'>$format_fchaHchos_incorrecta</td>
								    </tr>	
							   		";
							   }
							    
							    if($fecha_hchos_incorrecta > 0){
							    	$inconsistencia = 'FCHA_HCHOS_incorrecta';
							    	echo"
								    <tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                La fecha de hechos no es igual o anterior a la fecha de inicio:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$fecha_hchos_incorrecta</td>
								    </tr>
							    	";
							    } else {
							    	echo"
								    <tr>
								      <td>La fecha de hechos no es igual o anterior a la fecha de inicio:</td>
								      <td style='text-align: center;'>$fecha_hchos_incorrecta</td>
								    </tr>
							    	";
							    }

							   if($dia_fuera_rango > 0){
							   	$inconsistencia = 'dia_fcha_de_hchos_Incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Valor del día en la fecha de hechos incorrecto:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$dia_fuera_rango</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Valor del día en la fecha de hechos incorrecto:</td>
								      <td style='text-align: center;'>$dia_fuera_rango</td>
								    </tr>	
							   		";
							   }

							   if($long_fchaHchos_incorrecta > 0){
							   	$inconsistencia = 'long_fcha_de_hchos_Incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Longitud del dato de fecha de hechos incorrecta:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$long_fchaHchos_incorrecta</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Longitud del dato de fecha de hechos incorrecta:</td>
								      <td style='text-align: center;'>$long_fchaHchos_incorrecta</td>
								    </tr>	
							   		";
							   }  

							   if($tot_hra_de_hchos_null > 0){
							   		$inconsistencia = 'hora_de_hchos_sinDatos';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Falta la hora de hechos:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_hra_de_hchos_null</td>
								    </tr>
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Falta la hora de hechos:</td>
								      <td style='text-align: center;'>$tot_hra_de_hchos_null</td>
								    </tr>
							   		";
							   }

							   if($long_hraHchos_incorrecta > 0){
							   		$inconsistencia = 'long_hora_hchos_incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Longitud del dato de hora de hechos incorrecta:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$long_hraHchos_incorrecta</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Longitud del dato de hora de hechos incorrecta:</td>
								      <td style='text-align: center;'>$long_hraHchos_incorrecta</td>
								    </tr>	
							   		";
							   }

							   if($clave_emto_com_dto_incorrecta > 0){
							   		$inconsistencia = 'cve_emto_com_dto_incorrecta';
							   		echo"
							   		<tr>
								     <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Clave de elemento de comisión del delito no válida según el catálogo:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$clave_emto_com_dto_incorrecta</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Clave de elemento de comisión del delito no válida según el catálogo:</td>
								      <td style='text-align: center;'>$clave_emto_com_dto_incorrecta</td>
								    </tr>	
							   		";
							   } 

							   if($clave_grdo_cons_incorrecta > 0){
							   		$inconsistencia = 'cve_grdo_cons_incorrecta';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Clave de grado de consumación del delito no válida según el catálogo:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$clave_grdo_cons_incorrecta</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Clave de grado de consumación del delito no válida según el catálogo:</td>
								      <td style='text-align: center;'>$clave_grdo_cons_incorrecta</td>
								    </tr>	
							   		";
							   }

							   if($cve_clasf_dto_incorrecta > 0){
							   		$inconsistencia = 'cve_clasfDelito_incorrecta';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Clave de clasificación del delito no válida según el catálogo:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$cve_clasf_dto_incorrecta</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Clave de clasificación del delito no válida según el catálogo:</td>
								      <td style='text-align: center;'>$cve_clasf_dto_incorrecta</td>
								    </tr>	
							   		";
							   }  

							   if($tot_nom_ent_hchos_null > 0){
							   		$inconsistencia = 'nombre_entidad_sinDato';
							   		echo"
							   		<tr>
								     <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Falta la descripción de la entidad federativa:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_nom_ent_hchos_null</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Falta la descripción de la entidad federativa:</td>
								      <td style='text-align: center;'>$tot_nom_ent_hchos_null</td>
								    </tr>	
							   		";
							   } 

							   if($clave_ent_hchos_incorrecta > 0){
							   		$inconsistencia = 'cve_entFed_incorrecta';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Clave de entidad federativa no válida según el catálogo:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$clave_ent_hchos_incorrecta</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Clave de entidad federativa no válida según el catálogo:</td>
								      <td style='text-align: center;'>$clave_ent_hchos_incorrecta</td>
								    </tr>	
							   		";
							   }

							   if($tot_nom_mun_hchos_null > 0){
							   		$inconsistencia = 'nom_mun_hchos_sinDato';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Falta la descripción del municipio:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_nom_mun_hchos_null</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Falta la descripción del municipio:</td>
								      <td style='text-align: center;'>$tot_nom_mun_hchos_null</td>
								    </tr>	
							   		";
							   } 

							   if($clave_mun_hchos_incorrecta > 0){
							   		$inconsistencia = 'cve_mun_incorrecta';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Clave de municipio no válida según el catálogo:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$clave_mun_hchos_incorrecta</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Clave de municipio no válida según el catálogo:</td>
								      <td style='text-align: center;'>$clave_mun_hchos_incorrecta</td>
								    </tr>	
							   		";
							   }

							   if($tot_nom_col_hchos_null > 0){
							   		$inconsistencia = 'nom_colonia_sinDato';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Falta la descripción de la colonia:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_nom_col_hchos_null</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Falta la descripción de la colonia:</td>
								      <td style='text-align: center;'>$tot_nom_col_hchos_null</td>
								    </tr>	
							   		";
							   }

							   if($clave_cp_incorrecta > 0){
							   	$inconsistencia = 'cve_cp_incorrecta';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Código postal no válido según el catálogo:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$clave_cp_incorrecta</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Código postal no válido según el catálogo:</td>
								      <td style='text-align: center;'>$clave_cp_incorrecta</td>
								    </tr>	
							   		";
							   }

							   if($fmto_coord_x_incorrecto > 0){
							   		$inconsistencia = 'coord_x_fmato_incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Formato coordenada X incorrecto:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$fmto_coord_x_incorrecto</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Formato coordenada X incorrecto:</td>
								      <td style='text-align: center;'>$fmto_coord_x_incorrecto</td>
								    </tr>	
							   		";
							   }


								if($fmto_coord_y_incorrecto > 0){
									$inconsistencia = 'coord_y_fmato_incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Formato coordenada Y incorrecto:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$fmto_coord_y_incorrecto</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Formato coordenada Y incorrecto:</td>
								      <td style='text-align: center;'>$fmto_coord_y_incorrecto</td>
								    </tr>	
							   		";
							   }

							   if($tot_dom_hchos_null > 0){
							   		$inconsistencia = 'Dom_sinDato';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Falta la descripción del domicilio:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_dom_hchos_null</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Falta la descripción del domicilio:</td>
								      <td style='text-align: center;'>$tot_dom_hchos_null</td>
								    </tr>	
							   		";
							   }
							      
							    
					    echo"   
							  </tbody>
							</table>			
						</div>

<!-- TABLA VICTIMAS  -->
							<div class='card mt-5' style='border:none; background-color: #fff;'>
							<p class='card-header text-white font-weight-bold text-left' id='titulo' style='background: #691C32;'>Validacion archivo Victimas </p>
							<table class='tblCarpetas'>
							  <thead>
							    <tr style='text-align: center;'>
							      <th>Descripcion</th>
							      <th>Total Registros</th>
							    </tr>
							  </thead>
							  <tbody>
							    <tr>
							      <td>Total de registros en el archivo de víctimas:</td>
							      <td style='text-align: center;'>$totRegVictimas </td>
							    </tr>";

							    if($tot_id_ci_vict_null > 0){
							    	$inconsistencia = 'id_ci_vict_sinDato';
							    	echo"
								    <tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                \"ID_CI\" sin información:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_id_ci_vict_null</td>
								    </tr>
								    ";
							   }else{
							   		echo"
								    <tr>
								      <td>\"ID_CI\" sin información:</td>
								      <td style='text-align: center;'>$tot_id_ci_vict_null</td>
								    </tr>
								    ";
							   }

							   if($tot_id_delito_vict_null > 0){
							   		$inconsistencia = 'id_delito_vict_sinDato';
							    	echo"
								    <tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                \"ID_DELITO\" sin información:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_id_delito_vict_null</td>
								    </tr>
								    ";
							   }else{
							   		echo"
								    <tr>
								      <td>\"ID_DELITO\" sin información:</td>
								      <td style='text-align: center;'>$tot_id_delito_vict_null</td>
								    </tr>
								    ";
							   }

							   if($tot_id_vicf_null > 0){
							   		$inconsistencia = 'id_vicf_sinDato';
							    	echo"
							    	<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                \"ID_VICF\" sin información:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_id_vicf_null</td>
								    </tr>
							    	";
							    }else{
							    	echo"
							    	<tr>
								      <td>\"ID_VICF\" sin información:</td>
								      <td style='text-align: center;'>$tot_id_vicf_null</td>
								    </tr>
							    	";
							    }

							    if($tot_id_vicf_duplicados > 0){
							    	$inconsistencia = 'ID_VICF_duplicados';
							    	echo"
							    	<tr>
							           <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                \"ID_VICF\" duplicados:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_id_vicf_duplicados</td>
								    </tr>
							    	";
							    }else{
							    	echo"
							    	<tr>
								      <td>\"ID_VICF\" duplicados:</td>
								      <td style='text-align: center;'>$tot_id_vicf_duplicados</td>
								    </tr>
							    	";
							    }

							    if($clave_tv_incorrecto > 0){
							    	$inconsistencia = 'cve_tv_incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
							            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
							               style='display: inline-block; 
							                      padding: 6px 7px;
							                      color: #9F2241; 
							                      text-decoration: none; 
							                     '>
							                Tipo de víctima no válida según el catálogo:
							            </a>
							          </td>
								      <td style='text-align: center; Color: #9F2241;'>$clave_tv_incorrecto</td>
								    </tr>
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Tipo de víctima no válida según el catálogo:</td>
								      <td style='text-align: center;'>$clave_tv_incorrecto</td>
								    </tr>
							   		";
							   } 
							   if($clave_id_tpm_incorrecta > 0){
							   		$inconsistencia = 'id_tpm_incorrecto';
							   		echo"
									    <tr>
									        <td style='text-align: center;'>
									            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
									               style='display: inline-block; 
									                      padding: 6px 7px;
									                      color: #9F2241; 
									                      text-decoration: none; 
									                     '>
									                Tipo de persona moral no válida según el catálogo:
									            </a>
									        </td>
									        <td style='text-align: center; Color: #9F2241;'>$clave_id_tpm_incorrecta</td>
									    </tr>";
							   }else{
							   		echo"
							   		<tr>
								      <td>Tipo de persona moral no válida según el catálogo:</td>
								      <td style='text-align: center;'>$clave_id_tpm_incorrecta</td>
								    </tr>
							   		";
							   } 
							   if($clave_sexo_incorrecta > 0){
							   	   $inconsistencia = 'cve_sexo_incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Sexo no válido según el catálogo:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$clave_sexo_incorrecta</td>
								    </tr>
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Sexo no válido según el catálogo:</td>
								      <td style='text-align: center;'>$clave_sexo_incorrecta</td>
								    </tr>
							   		";
							   }

							   if($clave_genero_incorrecta > 0){
							   		$inconsistencia = 'cve_genero_incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Género no válido según el catálogo:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$clave_genero_incorrecta</td>
								    </tr>
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Género no válido según el catálogo:</td>
								      <td style='text-align: center;'>$clave_genero_incorrecta</td>
								    </tr>
							   		";
							   }

							   if($tot_pob_null > 0){
							   		$inconsistencia = 'dato_poblacion_incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                La pertenencia a población indígena no corresponde a los valores \"1\" o \"0\":
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_pob_null</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>La pertenencia a población indígena no corresponde a los valores \"1\" o \"0\":</td>
								      <td style='text-align: center;'>$tot_pob_null</td>
								    </tr>	
							   		";
							   }

							   if($tot_disc_incorrecto > 0){
							   		$inconsistencia = 'dato_discapacidad_incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                La presencia de discapacidad en la víctima no corresponde a los valores \"1\" o \"0\":
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$tot_disc_incorrecto</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>La presencia de discapacidad en la víctima no corresponde a los valores \"1\" o \"0\":</td>
								      <td style='text-align: center;'>$tot_disc_incorrecto</td>
								    </tr>	
							   		";
							   }

							   if($format_fcha_nac_incorrecto > 0){
							   		$inconsistencia = 'fmto_fchaNac_incorrecto';
							   		echo"
							   		<tr>
								     <td style='text-align: center;'>
							            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
							               style='display: inline-block; 
							                      padding: 6px 7px;
							                      color: #9F2241; 
							                      text-decoration: none; 
							                     '>
							                La fecha de nacimiento no cumple con las reglas de validación:
							            </a>
							          </td>
								      <td style='text-align: center; Color: #9F2241;'>$format_fcha_nac_incorrecto</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>La fecha de nacimiento no cumple con las reglas de validación:</td>
								      <td style='text-align: center;'>$format_fcha_nac_incorrecto</td>
								    </tr>	
							   		";
							   }

							   if($clave_edad_incorrecto > 0){
							   		$inconsistencia = 'edad_incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Edad no válida según el catálogo:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$clave_edad_incorrecto</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Edad no válida según el catálogo:</td>
								      <td style='text-align: center;'>$clave_edad_incorrecto</td>
								    </tr>	
							   		";
							   }

							   if($clave_nacionalidad_incorrecto > 0){
							   		$inconsistencia = 'cve_nacionalidad_incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Nacionalidad no válida según el catálogo:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$clave_nacionalidad_incorrecto</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Nacionalidad no válida según el catálogo:</td>
								      <td style='text-align: center;'>$clave_nacionalidad_incorrecto</td>
								    </tr>	
							   		";
							   }

							   if($clave_rel_vict_imputado_incorrecto > 0){
							   		$inconsistencia = 'rel_vict_input_incorrecto';
							   		echo"
							   		<tr>
								      <td style='text-align: center;'>
								            <a href='../../ConExportar/generar_csv/$cod_ref/$inconsistencia' 
								               style='display: inline-block; 
								                      padding: 6px 7px;
								                      color: #9F2241; 
								                      text-decoration: none; 
								                     '>
								                Relación entre víctima e imputado no válida según el catálogo:
								            </a>
								        </td>
								      <td style='text-align: center; Color: #9F2241;'>$clave_rel_vict_imputado_incorrecto</td>
								    </tr>	
							   		";
							   }else{
							   		echo"
							   		<tr>
								      <td>Relación entre víctima e imputado no válida según el catálogo:</td>
								      <td style='text-align: center;'>$clave_rel_vict_imputado_incorrecto</td>
								    </tr>	
							   		";
							   }

							    
					    echo"   
							  </tbody>
							</table>			
						</div>


					</div>	<!-- cierre del contenedor -->

					<br>";

						echo"	
							</body>
							</html>";



					if ($estatus_resVal_carpetas == 0 || $estatus_resVal_delitos == 0 || $estatus_resVal_victimas == 0 || $estatus_resValInteg == 0){

						echo"
							<div class='msgValidacionMAL'>
								<label>
									Las información que se muestra en las tablas, le permite identificar a detalle las inconsistencias identificadas en cada uno de los archivos enviados, es necesario atender dichas inconsistencias y cargar de nuevo sus archivos. 
								</label>
						    </div>
						    <br><br>";


						    	$expath1 = pathinfo($csv_data['file1_path']);
								$expath2 = pathinfo($csv_data['file2_path']);
								$expath3 = pathinfo($csv_data['file3_path']);

								$dirfiles = scandir($expath1['dirname']);

								$filenames = array($expath1['filename'].'.csv',$expath1['filename'].'.xls',$expath1['filename'].'.xlsx',$expath2['filename'].'.csv',$expath2['filename'].'.xls',$expath2['filename'].'.xlsx',$expath3['filename'].'.csv',$expath3['filename'].'.xls',$expath3['filename'].'.xlsx');

								$arrFiles = array_intersect($dirfiles, $filenames);

								
								if(count($arrFiles)>0){
									foreach ($arrFiles as $row) {
										//@unlink($expath1['dirname'].'/'.$row);
									}
								}
								$this->session->unset_userdata('csv_data');


					} else { 

						// Llamar PDF

						echo "
							<script>
								function concluirEnvio(){

									const v_codRef = " . json_encode($cod_ref) . ";
									const v_proceso = 'Previo';
			                        
								    ejecutaPeticionAjaxCargaSeccion('../../ConSeleccionador/abreModalAcuseEnvio/?cod_ref=' + encodeURIComponent(v_codRef) + '&proceso=' + encodeURIComponent(v_proceso), 'contenedorGeneral3');
								}


								setTimeout(concluirEnvio, 50);
								
								setTimeout(function() {
									const v_codRef = " . json_encode($cod_ref) . ";
									const v_proceso = " . json_encode($proceso) . ";

									let html = '<div class=\"col-md-4\">' +
										'<button id=\"btnRechazar\" type=\"button\" class=\"btn btn-danger btn-lg w-100\" onclick=\"rechazarCarga(\\'' + v_codRef + '\\', \\''
										 + v_proceso + '\\')\">Rechazar</button>' +
										'</div>' +
										'<div class=\"col-md-4\">' +
										'<button id=\"btnAceptar\" type=\"button\" class=\"btn btn-success btn-lg w-100\" onclick=\"aceptarCarga(\\'' + v_codRef + '\\', \\''
										 + v_proceso + '\\')\">Aceptar</button>' +
										'</div>';

									$('#divPDFBot').html(html);


								}, 20);


							</script>
						";	
				
					}


		}
        
    }


    public function cargarDatos(){
    	$cod_ref = $this->input->get('codigo');
		$proceso = $this->input->get('proceso');
		log_message('debug','Entrando a CargarDatos /////////////////////////////');
    	$csv_data = $this->session->userdata('csv_data');
    	$usuario_sesion = $this->session->usuario;

    	$error = "Success";

    	if($proceso=='CargaInfo'){

    		////////////////////////// Eliminar Existentes

    		$existe = $this->ModSeleccionarDatos->consultaPeriodoCarga($usuario_sesion);

    		if ($existe && $existe->ExisteRegistro > 0) {
    			$borrados = $this->ModSeleccionarDatos->borrarRegPrevio($usuario_sesion);
    			if ($borrados === false || $borrados === 0) {
    				echo json_encode([
    					'status' => false,
    					'msg'    => 'No se pudieron borrar los registros previos.'
    				]);
    				return;
    			}else{
    				$delRef = $existe->codigo_referencia;

    				$filesDir = 'public/Documentos/respaldosCSV/';
					$delRoute = $filesDir . $delRef . '*';
					$delFiles = glob($delRoute);

					foreach ($delFiles as $row) {
					    if (is_file($row)) {
					        unlink($row);
					    }
					}
    			}

    		}


	        /////////////////////////////

    		$this->ModInserccionDatos->InsertarTblsProduccion($cod_ref);

    		$destination_folder = "public/Documentos/respaldosCSV/";

    		$expath1 = pathinfo($csv_data['file1_path']);
    		$expath2 = pathinfo($csv_data['file2_path']);
    		$expath3 = pathinfo($csv_data['file3_path']);

    		$dirfiles = scandir($expath1['dirname']);

    		$filenames = array($expath1['filename'].'.csv',$expath1['filename'].'.xls',$expath1['filename'].'.xlsx',$expath2['filename'].'.csv',$expath2['filename'].'.xls',$expath2['filename'].'.xlsx',$expath3['filename'].'.csv',$expath3['filename'].'.xls',$expath3['filename'].'.xlsx');

    		$arrFiles = array_intersect($dirfiles, $filenames);


    		if(count($arrFiles)>0){
    			foreach ($arrFiles as $row) {
    				$newPath = $destination_folder.$cod_ref.'_'.$row;   // Es $codigoReferencia = $cod_ref?
    				rename($expath1['dirname'].'/'.$row,$newPath);
    				if(!file_exists($newPath)){
    					$error = "Error: Cannot move file: cUploadFiles line 2192";
    				}else{
    					@unlink($expath1['dirname'].'/'.$row);
    				}
    			}
    			$this->session->unset_userdata('csv_data');
    		}



    		echo $error;

    	}

    	if($proceso=='Actualizaciones'){

    		$anioCorte = $this->session->userdata('anio_corte');
    		$mesCorte  = $this->session->userdata('mes_corte');
    		$usuario_sesion = $this->session->usuario;
    		$this->session->unset_userdata(['anio_corte', 'mes_corte']);

    		$this->ModInserccionDatos->EnviarHistorico($usuario_sesion, $cod_ref,$anioCorte,$mesCorte);

    		$this->ModInserccionDatos->InsertarTblsProduccion($cod_ref); 

    		$destination_folder = "public/Documentos/respaldosCSV/";


    		$expath1 = pathinfo($csv_data['file1_path']);
    		$expath2 = pathinfo($csv_data['file2_path']);
    		$expath3 = pathinfo($csv_data['file3_path']);

    		$dirfiles = scandir($expath1['dirname']);

    		$filenames = array($expath1['filename'].'.csv',$expath1['filename'].'.xls',$expath1['filename'].'.xlsx',$expath2['filename'].'.csv',$expath2['filename'].'.xls',$expath2['filename'].'.xlsx',$expath3['filename'].'.csv',$expath3['filename'].'.xls',$expath3['filename'].'.xlsx');

    		$arrFiles = array_intersect($dirfiles, $filenames);


    		if(count($arrFiles)>0){
    			foreach ($arrFiles as $row) {
    				$newPath = $destination_folder.$cod_ref.'_'.$row;
    				rename($expath1['dirname'].'/'.$row,$newPath);
    				if(!file_exists($newPath)){
    					$error = "Error: Cannot move file: cUploadFiles line 2318";
    				}else{
    					@unlink($expath1['dirname'].'/'.$row);
    				}
    			}
    			$this->session->unset_userdata('csv_data');
    		}


    		echo $error;



    	}
    }


    public function rechazarDatos(){
    	$cod_ref = $this->input->get('codigo');
		$proceso = $this->input->get('proceso');

    	$csv_data = $this->session->userdata('csv_data');

    	$this->ModEliminarDatos->EliminarDatos($cod_ref);

    	$expath1 = pathinfo($csv_data['file1_path']);
    	$expath2 = pathinfo($csv_data['file2_path']);
    	$expath3 = pathinfo($csv_data['file3_path']);

    	$dirfiles = scandir($expath1['dirname']);

    	$filenames = array($expath1['filename'].'.csv',$expath1['filename'].'.xls',$expath1['filename'].'.xlsx',$expath2['filename'].'.csv',$expath2['filename'].'.xls',$expath2['filename'].'.xlsx',$expath3['filename'].'.csv',$expath3['filename'].'.xls',$expath3['filename'].'.xlsx');

    	$arrFiles = array_intersect($dirfiles, $filenames);


    	if(count($arrFiles)>0){
    		foreach ($arrFiles as $row) {
    			@unlink($expath1['dirname'].'/'.$row);
    		}
    	}
    	$this->session->unset_userdata('csv_data');

    	echo "Success";
    }

	
	private function xlsx2csv($file)
	{
	    log_message('debug', ">>> Entrando a xlsx2csv con archivo: " . print_r($file, true));

	    $extension = strtolower(pathinfo($file['file_name'], PATHINFO_EXTENSION));

	    if ($extension !== 'xlsx') {
	        log_message('error', "Extensión no válida: $extension");
	        return false;
	    }

	    $xlsx_path = $file['full_path'];
	    $csv_path  = $file['file_path'] . pathinfo($file['file_name'], PATHINFO_FILENAME) . '.csv';

	    try {
	        \PhpOffice\PhpSpreadsheet\Settings::setLibXmlLoaderOptions(LIBXML_COMPACT | LIBXML_PARSEHUGE);

	        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
	        $reader->setReadDataOnly(true);
	        $spreadsheet = $reader->load($xlsx_path);
	        $sheet = $spreadsheet->getActiveSheet();

	        // Columnas especiales
	        $columnas_fecha = ['FHA_DE_INI', 'FHA_DE_FIN', 'FHA_DE_HCHOS', 'FHA_NAC'];
	        $columnas_hora  = ['HRA_DE_INI', 'HRA_DE_FIN', 'HRA_DE_HCHOS'];

	        // Obtener encabezados verdaderos (ignorando columnas vacías a la derecha)
	        $headerRow = $sheet->rangeToArray("A1:ZZ1", null, true, false)[0];
	        $headers = [];

	        foreach ($headerRow as $value) {
	            if ($value === null || trim((string)$value) === '') {
	                break; // detenernos al encontrar la primera columna vacía
	            }
	            $headers[] = $value;
	        }

	        $colCount = count($headers);
	        $headers_upper = array_map('strtoupper', $headers);

	        $csv = fopen($csv_path, 'w');
	        if (!$csv) {
	            log_message('error', 'No se pudo abrir el archivo CSV para escritura: ' . $csv_path);
	            return false;
	        }

	        // Escribir encabezados al CSV
	        fputcsv($csv, $headers, ',');

	        // Leer fila por fila desde la segunda
	        $rowIterator = $sheet->getRowIterator(2);

	        foreach ($rowIterator as $row) {
	            $rowIndex = $row->getRowIndex();
	            $rowData = [];

	            for ($col = 1; $col <= $colCount; $col++) {
	                $cell = $sheet->getCellByColumnAndRow($col, $rowIndex);
	                $value = $cell ? $cell->getValue() : null;

	                $col_name = $headers_upper[$col - 1] ?? null;

	                if ($col_name) {
	                    if (in_array($col_name, $columnas_fecha)) {
	                        if (!empty($value)) {
	                            $formats = ['d/m/Y', 'd-m-Y', 'm/d/Y', 'Y-m-d', 'Y/m/d'];
	                            $converted = false;

	                            foreach ($formats as $fmt) {
	                                $date = DateTime::createFromFormat($fmt, $value);
	                                if ($date && $date->format($fmt) === $value) {
	                                    $value = $date->format('Y-m-d');
	                                    $converted = true;
	                                    break;
	                                }
	                            }

	                            if (!$converted) {
	                                $timestamp = strtotime($value);
	                                if ($timestamp !== false) {
	                                    $value = date('Y-m-d', $timestamp);
	                                }
	                            }
	                        }
	                    } elseif (in_array($col_name, $columnas_hora)) {
	                        if ($value === '' || $value === null) {
	                            $value = '';
	                        } elseif (trim($value) === '0' || trim($value) === '00:00:00') {
	                            $value = '00:00:00';
	                        } else {
	                            $timestamp = strtotime($value);
	                            $value = $timestamp ? date('H:i:s', $timestamp) : $value;
	                        }
	                    }
	                }

	                $rowData[] = $value;
	            }

	            fputcsv($csv, $rowData, ',');
	        }

	        fclose($csv);

	        // Eliminar salto de línea final si existe
	        $fp = fopen($csv_path, 'c+');
	        if ($fp !== false) {
	            fseek($fp, -1, SEEK_END);
	            $last_char = fgetc($fp);
	            if ($last_char === "\n") {
	                ftruncate($fp, ftell($fp) - 1);
	            }
	            fclose($fp);
	        }

	        log_message('debug', "CSV generado correctamente: $csv_path");

	        // Actualizar info del archivo convertido
	        $file['file_name'] = basename($csv_path);
	        $file['full_path'] = $csv_path;
	        $file['file_ext']  = '.csv';
	        $file['file_type'] = 'text/csv';

	        return $file;

	    } catch (Throwable $e) {
	        log_message('error', 'Error en xlsx2csv: ' . $e->getMessage() . ' en línea ' . $e->getLine() . ' en archivo ' . $e->getFile());
	        return false;
	    }
	}




		



}


	

?>