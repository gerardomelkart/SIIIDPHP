<?php 

class ConActualizar extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		//cargar modelo indicado
		$this->load->library('session');
	    $this->load->model('ModActualizaDatos');
	    $this->load->model('ModSeleccionarDatos');
	  
	}
	
	
	
	public function bajaUsuario($idUsuario){

		$ActEstatusUsuario = $this->ModActualizaDatos->bajaUsr($idUsuario);

					
			if(!empty($ActEstatusUsuario)){  
					
					echo "<script>
					Swal.fire({
						icon: 'success',
						title: 'Exito...',
						text: 'El usuario se dió de baja correctamente.'
					})
				</script>";

				} else {

					echo "<script>
					Swal.fire({
						icon: 'error',
						title: 'Error...',
						text: 'El usuario NO se dió de baja.'
					})
				</script>";			
				}

	}


	public function AdminConfig($habCargaInfo, $habModifInfo){


         $ActAdminConfig = $this->ModActualizaDatos->ActualizaAdminConfig($habCargaInfo, $habModifInfo);

         if(!empty($ActAdminConfig)){  
					
					echo "<script>
					Swal.fire({
						icon: 'success',
						title: 'Exito...',
						text: 'Configuracion actualizada correctamente.'
					})
				</script>";

				} else {

					echo "<script>
					Swal.fire({
						icon: 'error',
						title: 'Error...',
						text: 'Error al actualizar la configuración'
					})
				</script>";			
				}


	}


   

    






}
?>