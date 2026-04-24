<?php 

class ModInserccionDatos extends CI_Model{


	function __construct()
	{

		parent::__construct();
		$this->load->database();//cargar base de datos

	}
	

	

public function guardar_datos_txt($data, $table_name) {
	date_default_timezone_set('America/Mexico_City');
    // Validar el nombre de la tabla para evitar inyecciones SQL
    $allowed_tables = ['tabla1', 'tabla2', 'tabla3']; // Lista de tablas permitidas
    if (!in_array($table_name, $allowed_tables)) {
        return false;
    }
    
    // Insertar en la tabla seleccionada
    return $this->db->insert($table_name, $data);
}




// si la validacion de los archivos y su informacion cumple de manera corrcta, entonces mandamos los registros de las tablas temporales a las tablas de produccion.
public function InsertarTblsProduccion($cod_ref){


	$sql = "CALL sp_insertRegistros_a_tblsPrincipales(?)";
	    
	    // Ejecutar con parámetros bindeados para seguridad
	    $this->db->query($sql, array($cod_ref));

	    // Verificar si hubo errores
	    if ($this->db->error()['code']) {
	        // Manejar el error (puedes lanzar excepción o registrar log)
	        log_message('error', 'Error al insertar registros: ' . print_r($this->db->error(), true));
	        return false;
	    }
	    
	    return true;
}


public function insertarRegistroUsuario($Nombre,$Apaterno,$Amaterno,$rfc,$curp,$correo,$EntFed,$Rol,$Telefono,$NomUsuario,$Contrasena,$fechaAct,$usrSession){

		

			return $this->db->query("INSERT INTO usuarios (USUARIO, PASSWORD, NOMBRE, PRIMER_APELLIDO, SEGUNDO_APELLIDO, RFC, CURP, ROL, CORREO, TELEFONO_CONTACTO, CVE_ESTADO, VIGENTE, FECHA_ALTA, USUARIO_REG) 

		    VALUES ('$NomUsuario', '$Contrasena', '$Nombre', '$Apaterno', '$Amaterno', '$rfc', '$curp', '$Rol', '$correo', '$Telefono', '$EntFed', '1', '$fechaAct', '$usrSession')");


	}


public function EnviarHistorico($usuario_sesion, $cod_ref,$anioCorte,$mesCorte){

		$sql = "CALL sp_insertRegistros_a_tblsHistoricos(?,?,?,?)";
	    
	    $this->db->query($sql, array($usuario_sesion, $cod_ref,$anioCorte,$mesCorte));

	    // Verificar si hubo errores
	    if ($this->db->error()['code']) {
	        // Manejar el error (puedes lanzar excepción o registrar log)
	        log_message('error', 'Error al insertar registros: ' . print_r($this->db->error(), true));
	        return false;
	    }
	    
	    return true;

}	








 }
?>