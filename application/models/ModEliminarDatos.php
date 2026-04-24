<?php 

class ModEliminarDatos extends CI_Model{


	function __construct()
	{

		parent::__construct();
		$this->load->database();//cargar base de datos
	}
	
	

	
	public function EliminarDatos($cod_ref){

	
	    $sql = "CALL DeleteRegTmpArchivosIncorrectos(?)";
	    
	    // Ejecutar con parámetros bindeados para seguridad
	    $this->db->query($sql, array($cod_ref));
	    
	    // Verificar si hubo errores
	    if ($this->db->error()['code']) {
	        // Manejar el error (puedes lanzar excepción o registrar log)
	        log_message('error', 'Error al eliminar registros: ' . print_r($this->db->error(), true));
	        return false;
	    }
	    
	    return true;
	}


	




}	

?>