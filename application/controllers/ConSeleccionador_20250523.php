<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class ConSeleccionador extends CI_Controller{



	function __construct()
	{
		parent::__construct();
		//cargar modelo indicado
		//$this->load->library('session');
		//$this->load->library('pdf');
		//$this->load->library('Ciqrcode');
		//$this->load->helper('funciones');
		$this->load->model('ModSeleccionarDatos');

		    $this->load->library('pdf');
		    require_once APPPATH . 'libraries/dompdf/vendor/autoload.php'; // Carga Dompdf
		    $this->load->library('libraries/dompdf/pdf.php');
	}


	


	public function CargaVistaInicio(){
	
		$this->load->view("viewContenidoInicio");
	}



	public function abreModalUploadFiles(){
		
		echo "<script>
	    	 $('#modalUploadFiles').modal('show');
	    </script>";
	    
	   $this->load->view("viewModalCargaDeInformacion");

	}

	public function abreModalAcuseEnvio(){ // en el modal se manda a llamar la funcion createPDF la cual llama a la vista y se genera el pdf
      
		//obtenemos el codigo de referencia que se creo para identificar los registros de esa carga. y mandamos el parametro al modal para hacer la consulta de esos registros y generar la tabla con los conteos.
    $codigoRef = $_GET['cod_ref']; 
    $tipoProcc = $_GET['proceso']; 


    // Prepara los datos como variables JS
    echo "<script>
        // Variables con los datos
        var datosModal = {
            codigo: '" . $codigoRef . "',
            proceso: '" . $tipoProcc . "'
        };

        // Actualiza el modal con los datos
        $('#modalAcuseEnvio #codigo').text(datosModal.codigo);
        $('#modalAcuseEnvio #proceso').text(datosModal.proceso);

        // Muestra el modal.  el modal se encuentra en la vista inicio.php
        $('#modalAcuseEnvio').modal('show');
    </script>";
	          
    }

    

  

  public function createPDF(){

  	//recibimos el parametro codigo de referencia.
    $codigo = $_GET['codigo'] ?? '';
    $proceso = $_GET['proceso'] ?? '';


    if($proceso == 'CargaInfo'){
    	$data['dataInfAcuse'] = $this->ModSeleccionarDatos->ConsultaConstTablaAcuseRecibo($codigo,$proceso);
    	$data['tablaConteoDelitos'] = $this->ModSeleccionarDatos->ConsultaDelitosConstTablaAcuseRecibo($codigo);
   	  $this->load->view("viewAcuseEnvioPDF", $data);
    }

    if($proceso == 'Actualizaciones'){
    	$data['dataInfAcuse_Act'] = $this->ModSeleccionarDatos->ConsultaConstTablaAcuseRecibo($codigo,$proceso);
    	$data['dataInfAcuse_RegAnt'] = $this->ModSeleccionarDatos->ConsultaConstTablaAcuseRecibo_regAnt($codigo);
    	$data['tablaConteoDelitos'] = $this->ModSeleccionarDatos->ConsultaDelitosConstTablaAcuseRecibo($codigo);

   	  $this->load->view("viewAcuseEnvioPDF_act", $data);
    }

  	

   	//$CveEdo = $data[0]->CVE_ESTADO; 

     $this->pdf = new \Dompdf\Dompdf();
      
     $nomArch = 'ACUSE_' . $codigo;
      $html = $this->output->get_output();
        
        $this->load->library('session');
        $this->load->library('pdf');
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();
        $this->pdf->stream($nomArch, array("Attachment"=>0));

    }


    

	// public function CargaVistaIntegracion(){
	
	// 	$this->load->view("viewIntegracionInformacion");
	// }

  public function CargaVistaPanelControl(){
	    
		$this->load->view("viewPanelControl");
	}  

	public function CargaVistaRegUsuarios(){

		$data['tablaRegUsuarios'] = $this->ModSeleccionarDatos->reloadUsuarios();
	    
		$this->load->view("viewRegUsuarios", $data);
	}


	public function ObtenerDatosUsuario($idUsuario){

		$resultado = $this->ModSeleccionarDatos->obtenerUsuario($idUsuario);
		 
		 $idUsr = $resultado[0]->ID_USUARIO;
		 $cveusuario = $resultado[0]->USUARIO;
		 $nombre = $resultado[0]->NOMBRE;
		 $apellidop = $resultado[0]->PRIMER_APELLIDO;
		 $apellidom = $resultado[0]->SEGUNDO_APELLIDO;
		 $rfc = $resultado[0]->RFC;
		 $curp = $resultado[0]->CURP;
		 $rol = $resultado[0]->ROL;
		 $correo = $resultado[0]->CORREO;
		 $telContacto = $resultado[0]->TELEFONO_CONTACTO;
		 $cveEdo = $resultado[0]->CVE_ESTADO;
		 $vigente = $resultado[0]->VIGENTE;
		 $pass = $resultado[0]->PASSWORD;
		 
			

			echo "<script>
			
				document.getElementById('hiddenidUsuario').value = '$idUsr';
				document.getElementById('txtNombre').value = '$nombre';
				document.getElementById('txtApaterno').value = '$apellidop';
				document.getElementById('txtAmaterno').value = '$apellidom';
				document.getElementById('txtRFC').value = '$rfc';
				document.getElementById('txtCURP').value = '$curp';
				document.getElementById('txtCorreo').value = '$correo';
				document.getElementById('dlistEntFed').value = '$cveEdo';
				document.getElementById('dlistRol').value = '$rol';
				document.getElementById('txtTelefono').value = '$telContacto';
				document.getElementById('txtUsuario').value = '$cveusuario';
				document.getElementById('txtContrasena').value = '$pass';

				   var botonCancelar = document.getElementById('btnCancelEditUsr'); 

		        botonCancelar.style.visibility = 'visible';
		        botonCancelar.style.opacity = '1';

				</script>"; 


	}


	public function CargaVistaEnviarInf(){
	    
		$this->load->view("viewCargaDeInformacion");
	}

	public function CargaVistaActualizarInf(){
	    
		$this->load->view("viewActualizarInformacion");
	}

	
	public function CargaVistaConsultaEnvios(){

		$usuario = $this->session->usuario;
		$rol = $this->session->rol;
		$data['tablaConsultaEnvios'] = $this->ModSeleccionarDatos->ConsultarEnvios($usuario,$rol);
		$this->load->view("viewConsultaEnvios", $data);
	}



	public function CargaVistaDatosFiles(){
	    
		$this->load->view("viewDatosFiles");
	}


	public function ConsultaExistenReg($anioCorte,$mesCorte){

		//consultar en las tablas principales que existan registros del año y mes de corte que selecciono el usuario para actualizar
			$ConReg_a_Reemp = $this->ModSeleccionarDatos->ConsultReg_a_reemp($anioCorte,$mesCorte);


			if(!empty($ConReg_a_Reemp)){

				echo"<script>

							$('#divOpcCargaArchivos').show();
    		     
						 </script>";	
				

	   }else{

	   	echo "<script>
										Swal.fire(
										'Error',
										'Según el año y mes de corte seleccionados para actualizar su información, no se encontraron registros en la base de datos correspondientes a ese período. Por favor, verifique los datos.' ,
										'error'
										)
							</script>";

	   }


 }


 public function CargaVistaConfiguracion(){

 		$data['valoresConfig'] = $this->ModSeleccionarDatos->obtStatusConf();

 		$this->load->view("viewConfiguracion", $data);
 }





	
}

?>