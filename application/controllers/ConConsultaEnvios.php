<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

Class ConConsultaEnvios extends CI_Controller{



	function __construct()
	{
		parent::__construct();
		
		$this->load->model('ModConsultaEnvios');
  
		   
	}



	public function filtrarEnvios($opcFiltro,$vBusqueda) {


	    $data['tablaConsultaEnvios'] = $this->ModConsultaEnvios->filtrarRegEnvios($opcFiltro,$vBusqueda);

	    $this->load->view("viewConsultaEnvios", $data);
	    
	   // echo json_encode($resultados);
 }


	


	


	
}

?>