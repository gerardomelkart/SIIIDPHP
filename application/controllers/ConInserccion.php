<?php 

class ConInserccion extends CI_Controller{


	function __construct()
	{
		parent::__construct();
		//cargar modelo indicado
		$this->load->library('session');
		$this->load->model('ModInserccionDatos');
		$this->load->model('ModSeleccionarDatos');
		$this->load->model('ModActualizaDatos');
	}




    public function insertarRegUsuarios(){


    	$arregloFormulario = $this->input->post();

    	$usrSession = $this->session->usuario;
		$hiddenidUsuario	= $arregloFormulario['hiddenidUsuario'];
		$Nombre	= $arregloFormulario['txtNombre'];
		$Apaterno = $arregloFormulario['txtApaterno'];
		$Amaterno = $arregloFormulario['txtAmaterno'];
		$rfc	= $arregloFormulario['txtRFC'];
		$curp	= $arregloFormulario['txtCURP'];
		$correo	= $arregloFormulario['txtCorreo'];
		$EntFed	= $arregloFormulario['dlistEntFed'];
		$Rol	= $arregloFormulario['dlistRol'];
		$Telefono	= $arregloFormulario['txtTelefono'];
		$NomUsuario	= $arregloFormulario['txtUsuario'];
		$ContrasenaPlano = $arregloFormulario['txtContrasena'];


		//CREAR CONTRASEÑA
		$ContrasenaHash = password_hash($ContrasenaPlano, PASSWORD_DEFAULT);



		//TOMAR FECHA Y HORA ACTUAL
		date_default_timezone_set('America/Mexico_City');
		$fechaAct = date("Y-m-d:h:i:s");



		if ($hiddenidUsuario == 0)
    		{
    
    			$insertRegUsuario = $this->ModInserccionDatos->insertarRegistroUsuario($Nombre,$Apaterno,$Amaterno,$rfc,$curp,$correo,$EntFed,$Rol,$Telefono,$NomUsuario,$ContrasenaHash,$fechaAct,$usrSession);
    
    			if(!empty($insertRegUsuario)){  
    					
    					echo "<script>
    					Swal.fire(
    					'Guardado!',
    					'Sus datos se registraron correctamente!',
    					'success'
    					)
    					</script>";
    			} else {
    
    					echo "<script>
    							Swal.fire(
    							'Error!',
    							'Sus datos no se registraron!',
    							'error'
    							)
    							</script>";
    					}			
    
    			
    
    		}
    		else{
    
    			$actualizaRegUsuario = $this->ModActualizaDatos->actualizarusuarios($hiddenidUsuario,$Nombre,$Apaterno,$Amaterno,$rfc,$curp,$correo,$EntFed,$Rol,$Telefono,$NomUsuario);
    			
    			if(!empty($actualizaRegUsuario)){  
    					
    				echo "<script>
    				Swal.fire(
    				'Guardado!',
    				'Sus datos se actualizaron correctamente!',
    				'success'
    				)
    				</script>";
    			} else {
    
    				echo "<script>
    				Swal.fire(
    				'Error!',
    				'Sus datos no se actualizaron!',
    				'error'
    				)
    				</script>";
    				}
    		   
    
    		}	

    }
    
    




	


}

?>