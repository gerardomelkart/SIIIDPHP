<?php 

class ModConsultaEnvios extends CI_Model{


	function __construct()
	{

		parent::__construct();
		$this->load->database();//cargar base de datos

	}
	

	

	public function filtrarRegEnvios($opcFiltro,$vBusqueda) {



		if($opcFiltro == "Ninguno"){

			$condicion = "";
		}

		if($opcFiltro == "EntFed"){

			$condicion = "where t2.cve_estado = '$vBusqueda' ";
		}
		
		if($opcFiltro == "CorteInf"){

			$condicion = "where concat(t1.anio_corte, '-', t1.mes_corte) = '$vBusqueda' ";
		}

		if($opcFiltro == "Usrenvio"){

			$condicion = "where concat(t2.nombre, ' ', t2.primer_apellido, ' ', t2.segundo_apellido) like '%$vBusqueda%' ";
		}


		return $this->db->query("SELECT t1.usuario_reg, t1.codigo_referencia, DATE_FORMAT(t1.fcha_insert, '%d-%m-%Y') AS fcha_insert, 
										CASE t1.mes_corte
											WHEN 1 THEN concat('Enero', ' ', anio_corte)
											WHEN 2 THEN concat('Febrero', ' ', anio_corte)
											WHEN 3 THEN concat('Marzo', ' ', anio_corte)
											WHEN 4 THEN concat('Abril', ' ', anio_corte)
											WHEN 5 THEN concat('Mayo', ' ', anio_corte)
											WHEN 6 THEN concat('Junio', ' ', anio_corte)
											WHEN 7 THEN concat('Julio', ' ', anio_corte)
											WHEN 8 THEN concat('Agosto', ' ', anio_corte)
											WHEN 9 THEN concat('Septiembre', ' ', anio_corte)
											WHEN 10 THEN concat('Octubre', ' ', anio_corte)
											WHEN 11 THEN concat('Noviembre', ' ', anio_corte)
											WHEN 12 THEN concat('Diciembre', ' ', anio_corte)
										END AS mes_corte,
										 concat(t2.nombre, ' ', t2.primer_apellido, ' ', t2.segundo_apellido) AS usuario_envio, t2.cve_estado, t3.nom_ent FROM tbl_carpetas t1
											JOIN usuarios t2 ON t1.usuario_reg = t2.USUARIO
											JOIN cat_entidades t3 ON t2.cve_estado = t3.cve_ent
									        $condicion
											GROUP BY t1.usuario_reg, t1.codigo_referencia
											ORDER BY t1.usuario_reg, t1.codigo_referencia")->result();




    }








 }
?>