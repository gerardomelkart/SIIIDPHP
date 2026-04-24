<?php 

class ModActualizaDatos extends CI_Model{


	function __construct()
	{

		parent::__construct();
		$this->load->database();//cargar base de datos
		$this->load->library('session');
	}


	
	
	
	public function actualizarusuarios($hiddenidUsuario,$Nombre,$Apaterno,$Amaterno,$rfc,$curp,$correo,$EntFed,$Rol,$Telefono,$NomUsuario){

		
			return $this->db->query("UPDATE usuarios
								SET
								NOMBRE = '$Nombre',
								PRIMER_APELLIDO = '$Apaterno',
								SEGUNDO_APELLIDO = '$Amaterno',
								RFC = '$rfc',
								CURP = '$curp',
								ROL = '$Rol',
								CORREO = '$correo',
								TELEFONO_CONTACTO = '$Telefono',
								CVE_ESTADO = '$EntFed'
								WHERE ID_USUARIO = '$hiddenidUsuario' ");
	}


	public function bajaUsr($idUsuario){

		return $this->db->query("UPDATE usuarios
								   SET VIGENTE = '0'
								 WHERE ID_USUARIO = '$idUsuario'  ");
	}


	public function ActualizaAdminConfig($habCargaInfo, $habModifInfo){

		return $this->db->query("UPDATE tbl_admin_config
									SET hab_carga_info = $habCargaInfo,
									    hab_modifica_info = $habModifInfo ");
	}





}

?>