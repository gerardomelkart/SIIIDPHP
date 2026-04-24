<?php 



Class ConAcceso extends CI_Controller{



	function __construct()

	{

		parent::__construct();

		//cargar modelo indicado

		//$this->load->model('');
		$this->load->library('session');
		$this->load->model('ModSeleccionarDatos');
		
		if(!$this->session->usuario){
			redirect("../../");
		}
		

	}


	public function index(){

		$this->load->view("Inicio");
	}
	

}



?>