<?php 

Class ConAutenticacion extends CI_Controller{



	function __construct()

	{

		parent::__construct();

		//cargar modelo indicado

		//$this->load->model('');
		$this->load->library('session');
		$this->load->model('ModSeleccionarDatos');

	}


	public function index(){

		$this->load->view("view_inicio_sesion");
	}
	
	
	
	
	
	public function sesionIniciada()
	{
		if (!function_exists('password_hash')) {
		    log_message('error', 'La función password_hash() no existe');
		}
	    $recibeLogin = $this->input->post();
	    $usuario = $recibeLogin['txtusuario'];
	    $contrasena = $recibeLogin['txtcontrasena'];

	    $respuesta = $this->ModSeleccionarDatos->obtenConsultaLogin($usuario);

	    if (!empty($respuesta)) {
	        $usuario_bd = $respuesta[0];
	        $hash_bd = $usuario_bd->PASSWORD;

	        $encriptada = strpos($hash_bd, '$2y$') === 0;

	        $esValida = false;

	        if ($encriptada) {
	            $esValida = password_verify($contrasena, $hash_bd);
	        } else {
	            $esValida = ($contrasena === $hash_bd);
	            if ($esValida) {
	                $nuevoHash = password_hash($contrasena, PASSWORD_DEFAULT);
	                $this->ModSeleccionarDatos->actualizaPassword($usuario_bd->ID_USUARIO, $nuevoHash);
	            }
	        }

	        if ($esValida) {
	            $estatusConfig = $this->ModSeleccionarDatos->obtStatusConf();
	            if (!empty($estatusConfig)) {
	                $this->session->set_userdata("HabCargaInfo", $estatusConfig[0]->hab_carga_info);
	                $this->session->set_userdata("HabModifInfo", $estatusConfig[0]->hab_modifica_info);
	                $this->session->set_userdata("HabModuloDesaparecidos", $estatusConfig[0]->hab_modulo_desaparecidos);
					$this->session->set_userdata("HabActualizacionDesaparecidos", $estatusConfig[0]->hab_modulo_actualizacion_desaparecidos);
	            }

	            $this->session->set_userdata("usuario", $usuario_bd->USUARIO);
	            $this->session->set_userdata("nombre", $usuario_bd->NOMBRE);
	            $this->session->set_userdata("apellidop", $usuario_bd->PRIMER_APELLIDO);
	            $this->session->set_userdata("apellidom", $usuario_bd->SEGUNDO_APELLIDO);
	            $this->session->set_userdata("rol", $usuario_bd->ROL);
	            $this->session->set_userdata("ultima_actividad", time());

	            $this->output
	                ->set_content_type('application/json')
	                ->set_status_header(200)
	                ->set_output(json_encode(['message' => 'Ok']));
	        } else {
	            $this->output
	                ->set_content_type('application/json')
	                ->set_status_header(200)
	                ->set_output(json_encode(['message' => 'Usuario o contrasena incorrecto']));
	        }
	    } else {
	        $this->output
	            ->set_content_type('application/json')
	            ->set_status_header(200)
	            ->set_output(json_encode(['message' => 'Usuario o contrasena incorrecto']));
	    }
	}



	
	public function cerrarSesion(){
	    
	    $this->session->unset_userdata("usuario");
		$this->session->unset_userdata("contrasena");
		$this->session->unset_userdata("nombre");
		$this->session->unset_userdata("apellidop");
		$this->session->unset_userdata("apellidom");
		$this->session->unset_userdata("rol");
		$this->session->unset_userdata("HabCargaInfo");
		$this->session->unset_userdata("HabModifInfo");
		$this->session->unset_userdata("HabModuloDesaparecidos");
		$this->session->unset_userdata("HabActualizacionDesaparecidos");
		
		$this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode(array(
			'message' => 'Ok',
				
		)));
	}


	
}


?>