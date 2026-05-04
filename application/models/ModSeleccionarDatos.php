<?php 

class ModSeleccionarDatos extends CI_Model{


	function __construct()
	{

		parent::__construct();
		$this->load->database();//cargar base de datos
	}
	
	

	
	public function obtenConsultaLogin($usuario){

		 return $this->db
        ->where('USUARIO', $usuario)
        ->where('VIGENTE', 1)
        ->get('usuarios')
        ->result();

	}

	public function actualizaPassword($idUsuario, $nuevoHash)
	{
	    return $this->db
	        ->where('ID_USUARIO', $idUsuario)
	        ->update('usuarios', ['PASSWORD' => $nuevoHash]);
	}

	public function obtStatusConf(){
		return $this->db->query("SELECT * FROM tbl_admin_config")->result();
	}


	public function reloadUsuarios() {   


		return $this->db->query("SELECT ID_USUARIO, CONCAT(NOMBRE,' ', PRIMER_APELLIDO, ' ', SEGUNDO_APELLIDO) AS NOMBRE_COMPLETO, RFC, CURP, CORREO, TELEFONO_CONTACTO, 
							CASE
								WHEN CVE_ESTADO='01' THEN 'Aguascalientes'
							    WHEN CVE_ESTADO='02' THEN 'Baja California'
							    WHEN CVE_ESTADO='03' THEN 'Baja California Sur'
							    WHEN CVE_ESTADO='04' THEN 'Campeche'
							    WHEN CVE_ESTADO='05' THEN 'Coahuila de Zaragoza'
							    WHEN CVE_ESTADO='06' THEN 'Colima'
							    WHEN CVE_ESTADO='07' THEN 'Chiapas'
							    WHEN CVE_ESTADO='08' THEN 'Chihuahua'
							    WHEN CVE_ESTADO='09' THEN 'Ciudad de México'
							    WHEN CVE_ESTADO='10' THEN 'Durango'
							    WHEN CVE_ESTADO='11' THEN 'Guanajuato'
							    WHEN CVE_ESTADO='12' THEN 'Guerrero'
							    WHEN CVE_ESTADO='13' THEN 'Hidalgo'
							    WHEN CVE_ESTADO='14' THEN 'Jalisco'
							    WHEN CVE_ESTADO='15' THEN 'Estado de México'
							    WHEN CVE_ESTADO='16' THEN 'Michoacán de Ocampo'
							    WHEN CVE_ESTADO='17' THEN 'Morelos'
							    WHEN CVE_ESTADO='18' THEN 'Nayarit'
							    WHEN CVE_ESTADO='19' THEN 'Nuevo León'
							    WHEN CVE_ESTADO='20' THEN 'Oaxaca'
							    WHEN CVE_ESTADO='21' THEN 'Puebla'
							    WHEN CVE_ESTADO='22' THEN 'Querétaro'
							    WHEN CVE_ESTADO='23' THEN 'Quintana Roo'
							    WHEN CVE_ESTADO='24' THEN 'San Luis Potosí'
							    WHEN CVE_ESTADO='25' THEN 'Sinaloa'
							    WHEN CVE_ESTADO='26' THEN 'Sonora'
							    WHEN CVE_ESTADO='27' THEN 'Tabasco'
							    WHEN CVE_ESTADO='28' THEN 'Tamaulipas'
							    WHEN CVE_ESTADO='29' THEN 'Tlaxcala'
							    WHEN CVE_ESTADO='30' THEN 'Veracruz de Ignacio de la Llave'
							    WHEN CVE_ESTADO='31' THEN 'Yucatán'
							    WHEN CVE_ESTADO='32' THEN 'Zacatecas'
							 END AS ENTIDAD_FEDERATIVA, USUARIO, PASSWORD, 
							CASE
								WHEN ROL = 1 THEN 'Administrador'
							    WHEN ROL = 2 THEN 'Operador'
							    WHEN ROL = 3 THEN 'Consulta'
							 END AS ROL,   
							 FECHA_ALTA, USUARIO_REG
						FROM usuarios WHERE VIGENTE = '1'  ")->result();

    }


    public function obtenerUsuario($idUsuario){
		return $this->db->query("SELECT * FROM usuarios WHERE ID_USUARIO = $idUsuario ")->result();
	}





    public function get_table_columns($table_name){



    		return $this->db->query("SELECT COLUMN_NAME
										FROM INFORMATION_SCHEMA.COLUMNS
										WHERE TABLE_SCHEMA = 'db_integracion_scni'
										  AND TABLE_NAME = '$table_name'
										  AND ORDINAL_POSITION > 1 -- Excluye la primera columna (id)
										  AND ORDINAL_POSITION <= (
										    SELECT MAX(ORDINAL_POSITION) - 5 -- Excluye las últimas 5 columnas
										    FROM INFORMATION_SCHEMA.COLUMNS
										    WHERE TABLE_SCHEMA = 'db_integracion_scni'
										      AND TABLE_NAME = '$table_name'
										  )
										ORDER BY ORDINAL_POSITION")->result();


    	


    	
    }


    public function ValidarIntegridadDatos($codigoReferencia){

    	// Aumentar memoria temporalmente  
		ini_set('memory_limit', '1024M');



		 // Ejecutar el procedimiento almacenado
		    $query = $this->db->query("CALL sp_ValidarIntegridadReferencial('$codigoReferencia')");
		    
		    // Obtener el primer resultado (la selección final)
		    $resultados = $query->result();
		    
		    // Liberar el resultado principal
		    $query->free_result();
		    
		    // Consumir resultados adicionales (IMPORTANTE para MySQLi)
		    while ($this->db->conn_id->more_results()) {
		        $this->db->conn_id->next_result();
		        if ($result = $this->db->conn_id->store_result()) {
		            $result->free();
		        }
		    }

		    return $resultados;

		    $query->free_result(); // Libera la memoria ocupada por el resultado


    	
    }




    public function ValidarDatosArchCarpetasInv($codigoReferencia, $proceso, $anioCorte, $mesCorte){

    	    // Ejecutar el procedimiento almacenado
		    $query = $this->db->query("CALL sp_ValidarDatosArchCarpetas('$codigoReferencia', '$proceso', '$anioCorte', '$mesCorte')");
		    
		    // Obtener el primer resultado (la selección final)
		    $resultados = $query->result();
		    
		    // Liberar el resultado principal
		    $query->free_result();
		    
		    // Consumir resultados adicionales (IMPORTANTE para MySQLi)
		    while ($this->db->conn_id->more_results()) {
		        $this->db->conn_id->next_result();
		        if ($result = $this->db->conn_id->store_result()) {
		            $result->free();
		        }
		    }

		    return $resultados;

		    $query->free_result(); // Libera la memoria ocupada por el resultado


    	

    	
    }


    public function ValidarDatosArchDelitos($codigoReferencia){


	    	// Ejecutar el procedimiento almacenado
		    $query = $this->db->query("CALL sp_ValidarDatosArchDelitos('$codigoReferencia')");
		    
		    // Obtener el primer resultado (la selección final)
		    $resultados = $query->result();
		    
		    // Liberar el resultado principal
		    $query->free_result();
		    
		    // Consumir resultados adicionales (IMPORTANTE para MySQLi)
		    while ($this->db->conn_id->more_results()) {
		        $this->db->conn_id->next_result();
		        if ($result = $this->db->conn_id->store_result()) {
		            $result->free();
		        }
		    }

		    return $resultados;

 

    }




    public function ValidarDatosArchVictimas($codigoReferencia){

    	// Ejecutar el procedimiento almacenado
		    $query = $this->db->query("CALL sp_ValidarDatosArchVictimas('$codigoReferencia')");
		    
		    // Obtener el primer resultado (la selección final)
		    $resultados = $query->result();
		    
		    // Liberar el resultado principal
		    $query->free_result();
		    
		    // Consumir resultados adicionales (IMPORTANTE para MySQLi)
		    while ($this->db->conn_id->more_results()) {
		        $this->db->conn_id->next_result();
		        if ($result = $this->db->conn_id->store_result()) {
		            $result->free();
		        }
		    }

		    return $resultados;
		    

     	

     }




    public function ConsultaConstTablaAcuseRecibo($codigo,$proceso){

    	

	    	if($proceso == 'CargaInfo'){

    		return $this->db->query("SELECT 
										t2.CVE_ESTADO,
										t3.nom_ent AS DESC_ESTADO,
										COUNT(DISTINCT t1.id_ci) AS TotReg_carpetas,
										(SELECT COUNT(DISTINCT id_ci, id_delito, moda_dto, forma_acc, grdo_cons, clasf_de_dto) 
										 FROM tbl_delitos 
										 WHERE codigo_referencia = '$codigo') AS TotReg_delitos,
										(SELECT COUNT(DISTINCT id_ci, id_delito, id_vicf) 
										 FROM tbl_victimas 
										 WHERE codigo_referencia = '$codigo') AS TotReg_victimas,
										MAX(CASE t1.mes_corte 
											WHEN 1 THEN 'Enero' 
											WHEN 2 THEN 'Febrero'
											WHEN 3 THEN 'Marzo'
											WHEN 4 THEN 'Abril'
											WHEN 5 THEN 'Mayo'
											WHEN 6 THEN 'Junio'
											WHEN 7 THEN 'Julio'
											WHEN 8 THEN 'Agosto'
											WHEN 9 THEN 'Septiembre'
											WHEN 10 THEN 'Octubre'
											WHEN 11 THEN 'Noviembre'
											WHEN 12 THEN 'Diciembre'
											END) AS mes_corte,
										-- MAX(DATE_FORMAT(t1.fcha_insert, '%d de %M de %Y')) AS fecha_de_envio
								        MAX(CONCAT(
								        DATE_FORMAT(t1.fcha_insert, '%d de '),
								        CASE MONTH(t1.fcha_insert)
								            WHEN 1 THEN 'Enero'
								            WHEN 2 THEN 'Febrero'
								            WHEN 3 THEN 'Marzo'
								            WHEN 4 THEN 'Abril'
								            WHEN 5 THEN 'Mayo'
								            WHEN 6 THEN 'Junio'
								            WHEN 7 THEN 'Julio'
								            WHEN 8 THEN 'Agosto'
								            WHEN 9 THEN 'Septiembre'
								            WHEN 10 THEN 'Octubre'
								            WHEN 11 THEN 'Noviembre'
								            WHEN 12 THEN 'Diciembre'
								        END,
								        DATE_FORMAT(t1.fcha_insert, ' de %Y')
								    )) AS fecha_de_envio,
								       TIME(t1.fcha_insert) AS hora_de_envio 
									FROM tbl_carpetas t1
									INNER JOIN usuarios t2 
										ON t1.usuario_reg = t2.USUARIO
									INNER JOIN cat_entidades t3 
										ON t2.CVE_ESTADO = t3.cve_ent
									WHERE t1.codigo_referencia = '$codigo'
									GROUP BY t2.CVE_ESTADO, t3.nom_ent; ")->result();

	    	}
	    	
	    	if($proceso == 'Actualizaciones'){

	    		return $this->db->query("SELECT 
										    t2.CVE_ESTADO,
										    t3.nom_ent AS DESC_ESTADO,
										    COUNT(DISTINCT t1.id_ci) AS TotReg_carpetas,
										    (SELECT COUNT(DISTINCT id_ci, id_delito, moda_dto, forma_acc, grdo_cons, clasf_de_dto) 
										     FROM tbl_delitos 
										     WHERE codigo_referencia = '$codigo') AS TotReg_delitos,
										    (SELECT COUNT(DISTINCT id_ci, id_delito, id_vicf) 
										     FROM tbl_victimas 
										     WHERE codigo_referencia = '$codigo') AS TotReg_victimas,
										    MAX(CASE t1.mes_corte 
										        WHEN 1 THEN 'Enero' 
										        WHEN 2 THEN 'Febrero'
												WHEN 3 THEN 'Marzo'
												WHEN 4 THEN 'Abril'
												WHEN 5 THEN 'Mayo'
												WHEN 6 THEN 'Junio'
												WHEN 7 THEN 'Julio'
												WHEN 8 THEN 'Agosto'
												WHEN 9 THEN 'Septiembre'
												WHEN 10 THEN 'Octubre'
												WHEN 11 THEN 'Noviembre'
												WHEN 12 THEN 'Diciembre'
										        END) AS mes_corte,
										    -- MAX(DATE_FORMAT(t1.fcha_insert, '%d de %M de %Y')) AS fecha_de_envio
										    MAX(CONCAT(
										        DATE_FORMAT(t1.fcha_insert, '%d de '),
										        CASE MONTH(t1.fcha_insert)
										            WHEN 1 THEN 'Enero'
										            WHEN 2 THEN 'Febrero'
										            WHEN 3 THEN 'Marzo'
										            WHEN 4 THEN 'Abril'
										            WHEN 5 THEN 'Mayo'
										            WHEN 6 THEN 'Junio'
										            WHEN 7 THEN 'Julio'
										            WHEN 8 THEN 'Agosto'
										            WHEN 9 THEN 'Septiembre'
										            WHEN 10 THEN 'Octubre'
										            WHEN 11 THEN 'Noviembre'
										            WHEN 12 THEN 'Diciembre'
										        END,
										        DATE_FORMAT(t1.fcha_insert, ' de %Y')
										    )) AS fecha_de_envio,
										    TIME(t1.fcha_insert) AS hora_de_envio 
										FROM tbl_carpetas t1
										INNER JOIN usuarios t2 
										    ON t1.usuario_reg = t2.USUARIO
										INNER JOIN cat_entidades t3 
										    ON t2.CVE_ESTADO = t3.cve_ent
										WHERE t1.codigo_referencia = '$codigo'
										GROUP BY t2.CVE_ESTADO, t3.nom_ent; ")->result();

	    	}


	    	if($proceso == 'Previo'){

	    		return $this->db->query("SELECT 
										    t2.CVE_ESTADO,
										    t3.nom_ent AS DESC_ESTADO,
										    COUNT(DISTINCT t1.id_ci) AS TotReg_carpetas,
										    (SELECT COUNT(DISTINCT id_ci, id_delito, moda_dto, forma_acc, grdo_cons, clasf_de_dto) 
										     FROM tmp_delitos 
										     WHERE codigo_referencia = '$codigo') AS TotReg_delitos,
										    (SELECT COUNT(DISTINCT id_ci, id_delito, id_vicf) 
										     FROM tmp_victimas 
										     WHERE codigo_referencia = '$codigo') AS TotReg_victimas,
										    MAX(CASE t1.mes_corte 
										        WHEN 1 THEN 'Enero' 
										        WHEN 2 THEN 'Febrero'
												WHEN 3 THEN 'Marzo'
												WHEN 4 THEN 'Abril'
												WHEN 5 THEN 'Mayo'
												WHEN 6 THEN 'Junio'
												WHEN 7 THEN 'Julio'
												WHEN 8 THEN 'Agosto'
												WHEN 9 THEN 'Septiembre'
												WHEN 10 THEN 'Octubre'
												WHEN 11 THEN 'Noviembre'
												WHEN 12 THEN 'Diciembre'
										        END) AS mes_corte,
										    MAX(DATE_FORMAT(t1.fcha_insert, '%d de %M de %Y')) AS fecha_de_envio
										FROM tmp_carpetas t1
										INNER JOIN usuarios t2 
										    ON t1.usuario_reg = t2.USUARIO
										INNER JOIN cat_entidades t3 
										    ON t2.CVE_ESTADO = t3.cve_ent
										WHERE t1.codigo_referencia = '$codigo'
										GROUP BY t2.CVE_ESTADO, t3.nom_ent; ")->result();

	    	}

    }



    public function ConsultaConstTablaAcuseRecibo_regAnt($codigo){

    	return $this->db->query("SELECT
								    (SELECT COUNT(DISTINCT id_ci) 
								     FROM tbl_carpetas_historico 
								     WHERE codigo_referencia_nvo = '$codigo'
								    ) AS TotReg_carpetas_hist,
								    
								    (SELECT COUNT(DISTINCT id_ci, id_delito, moda_dto, forma_acc, grdo_cons, clasf_de_dto) 
								     FROM tbl_delitos_historico 
								     WHERE codigo_referencia IN (
								         SELECT codigo_referencia 
								         FROM tbl_carpetas_historico 
								         WHERE codigo_referencia_nvo = '$codigo'
								     )
								    ) AS TotReg_delitos_hist,
								    
								    (SELECT COUNT(DISTINCT id_ci, id_delito, id_vicf) 
								     FROM tbl_victimas_historico 
								     WHERE codigo_referencia IN (
								         SELECT codigo_referencia 
								         FROM tbl_carpetas_historico 
								         WHERE codigo_referencia_nvo = '$codigo'
								     )
								    ) AS TotReg_victimas_hist;")->result();

    }




    


    public function ConsultaDelitosConstTablaAcuseRecibo($codigo){


    	return $this->db->query("SELECT 
									c.clave2_s, 
									c.delito_sabana, 
									c.clave3_s, 
									c.subtipo_delito_sabana, 
									COUNT(DISTINCT d.pk_del) AS tot_delitos, 
									COUNT(DISTINCT v.pk_vict) AS tot_victimas
								FROM db_integracion_scni.cat_delitos_sabana c
								LEFT JOIN tbl_delitos d
									ON c.clave4 = d.clasf_de_dto 
									AND c.id_grdo_cons = d.grdo_cons
									AND c.id_emto_com_dto = d.emto_com_dto
									AND c.id_forma_acc = d.forma_acc
									AND d.codigo_referencia = '$codigo'
								LEFT JOIN tbl_victimas v
								ON d.pk_del = v.pk_del
								GROUP BY c.clave2_s, c.delito_sabana, c.clave3_s, c.subtipo_delito_sabana
								ORDER BY c.clave2_s, c.delito_sabana, c.clave3_s, c.subtipo_delito_sabana")->result();


    }



    public function ConsultaDelitosConstTablaAcuseReciboPrev($codigo){


   

    	return $this->db->query("SELECT 
									c.clave2_s, 
									c.delito_sabana, 
									c.clave3_s, 
									c.subtipo_delito_sabana, 
									COUNT(DISTINCT d.pk_del) AS tot_delitos, 
									COUNT(DISTINCT v.pk_vict) AS tot_victimas
								FROM cat_delitos_sabana c
								LEFT JOIN tmp_delitos d
									ON c.clave4 = d.clasf_de_dto 
									AND c.id_grdo_cons = d.grdo_cons
									AND c.id_emto_com_dto = d.emto_com_dto
									AND c.id_forma_acc = d.forma_acc
									AND d.codigo_referencia = '$codigo'
								LEFT JOIN tmp_victimas v
								ON d.id_ci = v.id_ci and d.id_delito=v.id_delito
								AND d.codigo_referencia = v.codigo_referencia
								GROUP BY c.clave2_s, c.delito_sabana, c.clave3_s, c.subtipo_delito_sabana
								ORDER BY c.clave2_s, c.delito_sabana, c.clave3_s, c.subtipo_delito_sabana")->result();


    }



    public function ConsultarEnvios($usuario,$rol){

    	if($rol == 1){

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
										 concat(t2.nombre, ' ', t2.primer_apellido, ' ', t2.segundo_apellido) AS usuario_envio, t2.cve_estado, t3.nom_ent 
										    FROM tbl_carpetas t1
											JOIN usuarios t2 ON t1.usuario_reg = t2.USUARIO
											JOIN cat_entidades t3 ON t2.cve_estado = t3.cve_ent
											GROUP BY t1.usuario_reg, t1.codigo_referencia
											ORDER BY t1.usuario_reg, t1.codigo_referencia")->result();

    	}else{

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
											WHERE t1.usuario_reg = '$usuario'
											GROUP BY t1.usuario_reg, t1.codigo_referencia
											ORDER BY t1.usuario_reg, t1.codigo_referencia ")->result();
	    }
    }





    public function ConsultarRptCargas(){

    	// Ejecutar el procedimiento almacenado
		    $query = $this->db->query("CALL sp_consultaRptCargas()");
		    
		    // Obtener el primer resultado (la selección final)
		    $resultados = $query->result();
		    
		    // Liberar el resultado principal
		    $query->free_result();
		    
		    // Consumir resultados adicionales (IMPORTANTE para MySQLi)
		    while ($this->db->conn_id->more_results()) {
		        $this->db->conn_id->next_result();
		        if ($result = $this->db->conn_id->store_result()) {
		            $result->free();
		        }
		    }

		    return $resultados;

    }




    public function obtRegInconsistencias($codRef,$inconsistencia){



/************************registros validacion integridad referencial *********************/



		if ($inconsistencia == 'tot_menosVICvsDEL'){

    		return $this->db->query("SELECT 
									    d.ID_CI,
									    d.ID_DELITO,
									    d.total_delitos,
									    COALESCE(v.total_victimas, 0) AS total_victimas
									FROM (
									    SELECT 
									        ID_CI,
									        ID_DELITO,
									        COUNT(*) AS total_delitos
									    FROM tmp_delitos
									    WHERE  tmp_delitos.codigo_referencia = '$codRef'  
									    GROUP BY ID_CI, ID_DELITO
									) d
									LEFT JOIN (
									    SELECT 
									        ID_CI,
									        ID_DELITO,
									        COUNT(*) AS total_victimas
									    FROM tmp_victimas
									    WHERE EXISTS ( 
									        SELECT 1 
									        FROM tmp_delitos 
											WHERE tmp_victimas.codigo_referencia = '$codRef'
									        AND tmp_delitos.ID_CI = tmp_victimas.ID_CI
									        AND tmp_delitos.ID_DELITO = tmp_victimas.ID_DELITO
									    )
									    GROUP BY ID_CI, ID_DELITO
									) v ON d.ID_CI = v.ID_CI AND d.ID_DELITO = v.ID_DELITO
									WHERE d.total_delitos > COALESCE(v.total_victimas, 0)")->result();

    	}


    	if ($inconsistencia == 'tot_Reg_Carp_noExist_delit'){

    		return $this->db->query("SELECT * from tmp_carpetas c
										where not exists (select * from tmp_delitos d where d.id_ci = c.id_ci and d.codigo_referencia = '$codRef')
										and c.codigo_referencia = '$codRef'")->result();

    	}


    	if ($inconsistencia == 'tot_Reg_Carp_noExist_vict'){

    		return $this->db->query("SELECT * from tmp_carpetas c
										where not exists (select * from tmp_victimas v where v.id_ci = c.id_ci and v.codigo_referencia = '$codRef')
										and c.codigo_referencia = '$codRef'")->result();

    	}

    	if ($inconsistencia == 'tot_Reg_Delit_noExist_carp'){

    		return $this->db->query("SELECT * from tmp_delitos d
										where not exists (select * from tmp_carpetas c where c.id_ci = d.id_ci and c.codigo_referencia = '$codRef')
										and d.codigo_referencia = '$codRef'")->result();

    	}

    	if ($inconsistencia == 'tot_Reg_Delit_noExist_vict'){

    		return $this->db->query("SELECT * from tmp_delitos d
										where not exists (select * from tmp_victimas v where d.id_ci = v.id_ci and d.id_delito = v.id_delito and v.codigo_referencia = '$codRef')
										and d.codigo_referencia = '$codRef'")->result();

    	}

    	if ($inconsistencia == 'tot_Reg_vict_noExist_carp'){

    		return $this->db->query("SELECT * from tmp_victimas v
										where not exists (select * from tmp_carpetas c  where v.id_ci = c.id_ci and c.codigo_referencia = '$codRef')
										and v.codigo_referencia = '$codRef'")->result();

    	}

    	if ($inconsistencia == 'tot_Reg_vict_noExist_delit'){

    		return $this->db->query("SELECT * from tmp_victimas v
										where not exists (select * from tmp_delitos d  where v.id_ci = d.id_ci and v.id_delito = d.id_delito and d.codigo_referencia = '$codRef')
										and v.codigo_referencia = '$codRef'")->result();

		}




/************************registros carpetas***********************************************/
    	
    	if ($inconsistencia == 'id_ci_sinDato'){

    		return $this->db->query("SELECT id_ci, ntra_ci FROM tmp_carpetas
										WHERE (id_ci IS NULL OR id_ci = '')
										AND codigo_referencia = '$codRef'")->result();

    	}

    	if ($inconsistencia == 'ID_CI_duplicados'){ 

    		return $this->db->query("SELECT id_ci, COUNT(*) AS duplicados
										FROM tmp_carpetas
										where codigo_referencia = '$codRef'
										GROUP BY id_ci
										HAVING duplicados > 1")->result();

    	}	

    	
    	if ($inconsistencia == 'nomenclatura_sinDato'){ 

    		return $this->db->query("SELECT id_ci, ntra_ci FROM tmp_carpetas
										WHERE (ntra_ci IS NULL OR ntra_ci = '')
										AND codigo_referencia = '$codRef'")->result();

    	}

    	
    	if ($inconsistencia == 'fechaInicio_sinDato'){ 

    		return $this->db->query("SELECT id_ci, ntra_ci, fha_de_ini FROM tmp_carpetas
										WHERE (fha_de_ini IS NULL OR fha_de_ini = '')
										AND codigo_referencia = '$codRef'")->result();

    	}

    	
    	if ($inconsistencia == 'fmto_fechaInicio_incorrecto'){ 

    		return $this->db->query("SELECT id_ci, ntra_ci, fha_de_ini FROM tmp_carpetas
										WHERE fha_de_ini NOT REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$'
										AND codigo_referencia = '$codRef' ")->result();

    	}

    	
    	if ($inconsistencia == 'dia_fechaInicio_incorrecto'){ 

    		return $this->db->query("SELECT id_ci, ntra_ci, fha_de_ini FROM tmp_carpetas
										WHERE SUBSTRING(fha_de_ini, 9,2)  NOT BETWEEN 1 AND 31
										AND codigo_referencia = '$codRef'")->result();

    	}


    	if ($inconsistencia == 'FHA_INI_fraRango'){

    		return $this->db->query("SELECT id_ci, ntra_ci, fha_de_ini FROM tmp_carpetas t1
										WHERE LEFT(t1.fha_de_ini, 7) <> DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m')
										 AND codigo_referencia = '$codRef'")->result();

    	}	


    	
    	if ($inconsistencia == 'hora_ini_sinDato'){

    		return $this->db->query("SELECT id_ci, ntra_ci, hra_de_ini FROM tmp_carpetas
										WHERE (hra_de_ini IS NULL)
										AND codigo_referencia = '$codRef'")->result();

    	}

    	
    	if ($inconsistencia == 'fmto_hra_ini_incorrecto'){

    		return $this->db->query("SELECT id_ci, ntra_ci, hra_de_ini FROM tmp_carpetas
										WHERE hra_de_ini NOT REGEXP '^([01][0-9]|2[0-4]):[0-5][0-9]:[0-5][0-9]$'
										AND hra_de_ini <> ''
										AND codigo_referencia = '$codRef'")->result();

    	}

    	
    	if ($inconsistencia == 'cve_tipo_exp_incorrecto'){

    		return $this->db->query("SELECT t1.id_ci, t1.ntra_ci, t1.id_texp FROM tmp_carpetas t1
										WHERE NOT EXISTS (SELECT * FROM cat_tipo_expediente T2
															WHERE t1.id_texp = t2.clave)                 
										 AND t1.codigo_referencia = '$codRef'")->result();

    	}






/*******************************VALIDACIONES DELITOS********************************************/
		


		if ($inconsistencia == 'ID_CI_enDELITOS_null'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.dto FROM tmp_delitos t1
										WHERE (t1.id_ci IS NULL OR t1.id_ci = '') 
										AND t1.codigo_referencia = '$codRef'")->result();

    	}

    	if ($inconsistencia == 'ID_DELITO_null'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.dto FROM tmp_delitos t1
										WHERE (t1.id_delito IS NULL OR t1.id_delito = '') 
										AND t1.codigo_referencia = '$codRef'")->result();

    	}





    	if ($inconsistencia == 'ID_DELITO_duplicados'){

    		return $this->db->query("SELECT id_ci, id_delito, moda_dto, forma_acc, grdo_cons, clasf_de_dto FROM tmp_delitos
										where codigo_referencia = '$codRef'
										GROUP BY id_ci, id_delito, moda_dto, forma_acc, grdo_cons, clasf_de_dto
										HAVING COUNT(*) > 1 ")->result();

    	}


    	if ($inconsistencia == 'Desc_delito_null'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.dto FROM tmp_delitos t1
										WHERE (t1.dto IS NULL OR t1.dto = '') 
										AND t1.codigo_referencia = '$codRef'")->result();

    	}

    	
    	if ($inconsistencia == 'dto_principal_incorrecto'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.dto, t1.dto_prin FROM tmp_delitos t1
										WHERE t1.dto_prin NOT IN (0,1) 
										AND t1.codigo_referencia = '$codRef'")->result();

    	}


    	if ($inconsistencia == 'CI_masdeuno_o_sin_dto_prin'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.dto_prin
										FROM tmp_delitos t1
										WHERE t1.codigo_referencia = '$codRef'
										AND t1.id_ci IN (
										    SELECT id_ci
										    FROM tmp_delitos
										    WHERE codigo_referencia = '$codRef'
										    GROUP BY id_ci
										    HAVING SUM(dto_prin) <> 1
										)
										ORDER BY t1.id_ci, t1.id_delito;")->result();

    	}

    	if ($inconsistencia == 'Modalidad_dto_sinDato'){

    		return $this->db->query("SELECT id_ci, id_delito, dto, dto_prin, moda_dto FROM tmp_delitos
 										WHERE (moda_dto IS NULL OR moda_dto = '')
 										AND codigo_referencia = '$codRef'")->result();
    	}


    	
    	if ($inconsistencia == 'FCHA_HCHOS_incorrecta'){

    		return $this->db->query("SELECT DISTINCT t1.id_ci, t1.id_delito, t1.fha_de_hchos 
										FROM tmp_delitos t1
										LEFT JOIN tmp_carpetas t2 ON t1.id_ci = t2.id_ci 
										WHERE STR_TO_DATE(t1.fha_de_hchos, '%Y-%m-%d') > STR_TO_DATE(t2.fha_de_ini, '%Y-%m-%d') 
										AND t1.codigo_referencia = '$codRef'")->result();

    	}

    	

    	
    	if ($inconsistencia == 'cve_formaAccionIncorrecta'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.dto, t1.forma_acc FROM tmp_delitos t1
									 WHERE NOT EXISTS (SELECT * FROM cat_forma_accion t2
														WHERE t1.forma_acc = t2.clave )
												AND t1.codigo_referencia = '$codRef'")->result();

    	}

    	
    	if ($inconsistencia == 'fcha_de_hchos_null'){

    			return $this->db->query("SELECT id_ci, id_delito, dto, fha_de_hchos FROM tmp_delitos
										 WHERE (fha_de_hchos IS NULL OR fha_de_hchos = '')
										AND codigo_referencia = '$codRef' ")->result();
    	}

    	
    	if ($inconsistencia == 'fcha_de_hchos_formatoIncorrecto'){

    		return $this->db->query("SELECT id_ci, id_delito, dto, fha_de_hchos FROM tmp_delitos
										WHERE fha_de_hchos <> ''
										AND ( fha_de_hchos NOT REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$'  OR  CAST(SUBSTRING(fha_de_hchos, 1,1) AS SIGNED) < 1 )
										AND codigo_referencia = '$codRef'")->result();

    	}

    	
    	if ($inconsistencia == 'dia_fcha_de_hchos_Incorrecto'){

    		return $this->db->query("SELECT id_ci, id_delito, dto, fha_de_hchos FROM tmp_delitos
										WHERE CAST(SUBSTRING(fha_de_hchos, 9,2) AS SIGNED) NOT BETWEEN 1 AND 31
										AND  codigo_referencia = '$codRef'")->result();
    	}

    	
    	if ($inconsistencia == 'long_fcha_de_hchos_Incorrecto'){

    		return $this->db->query("SELECT id_ci, id_delito, dto, fha_de_hchos FROM tmp_delitos
										WHERE LENGTH(fha_de_hchos) <> 10
										AND  codigo_referencia = '$codRef'")->result();
    	}

    	
    	if ($inconsistencia == 'hora_de_hchos_sinDatos'){

    		return $this->db->query("SELECT id_ci, id_delito, dto, hra_de_hchos FROM tmp_delitos
										WHERE (hra_de_hchos IS NULL OR hra_de_hchos = '')
										AND codigo_referencia = '$codRef' ")->result();
    	}

    	
    	if ($inconsistencia == 'long_hora_hchos_incorrecto'){

    		return $this->db->query("SELECT id_ci, id_delito, dto, hra_de_hchos FROM tmp_delitos
										WHERE LENGTH(hra_de_hchos) <> 8
										AND codigo_referencia = '$codRef' ")->result();
    	}

    	
    	if ($inconsistencia == 'cve_emto_com_dto_incorrecta'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.dto, t1.emto_com_dto FROM tmp_delitos t1
									 WHERE NOT EXISTS (SELECT * FROM cat_instrumentos_comision t2
														WHERE t1.emto_com_dto = t2.clave )
												AND t1.codigo_referencia = '$codRef'")->result();
    	}


    	if ($inconsistencia == 'cve_grdo_cons_incorrecta'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.dto, t1.grdo_cons FROM tmp_delitos t1
										 WHERE NOT EXISTS (SELECT * FROM cat_grado_consumacion t2
															WHERE t1.grdo_cons = t2.clave )
													AND t1.codigo_referencia = '$codRef' ")->result();
    	}

    	
    	if ($inconsistencia == 'cve_clasfDelito_incorrecta'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.dto, t1.clasf_de_dto FROM tmp_delitos t1
									 WHERE NOT EXISTS (SELECT * FROM cat_delitos t2
														WHERE t1.clasf_de_dto = t2.clave4 )
												AND t1.codigo_referencia = '$codRef' ")->result();
    	}

    	
    	if ($inconsistencia == 'nombre_entidad_sinDato'){

    		return $this->db->query("SELECT id_ci, id_delito, dto, nom_ent_hchos FROM tmp_delitos
										WHERE (nom_ent_hchos IS NULL OR nom_ent_hchos = '')
										AND codigo_referencia = '$codRef' ")->result();
    	}

    	
    	if ($inconsistencia == 'cve_entFed_incorrecta'){

    		return $this->db->query(" SELECT t1.id_ci, t1.id_delito, t1.dto, t1.id_ent_hchos
										 FROM tmp_delitos t1 
										 INNER JOIN usuarios u ON t1.usuario_reg = u.usuario   
										 WHERE (
										   NOT EXISTS ( 
										     SELECT 1
										     FROM cat_entidades t2 
										     WHERE CAST(t1.id_ent_hchos AS UNSIGNED) = CAST(t2.cve_ent AS UNSIGNED) 
										   ) 
										   OR 
										   CAST(t1.id_ent_hchos AS UNSIGNED) <> CAST(u.cve_estado AS UNSIGNED)
										 )
										 AND t1.codigo_referencia = '$codRef'")->result();
    	}

    	
    	if ($inconsistencia == 'nom_mun_hchos_sinDato'){

    		return $this->db->query("SELECT id_ci, id_delito, dto, nom_mun_hchos FROM tmp_delitos
										WHERE (nom_mun_hchos IS NULL OR nom_mun_hchos = '')
										AND codigo_referencia = '$codRef' ")->result();
    	}

    	
    	if ($inconsistencia == 'cve_mun_incorrecta'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.dto, t1.id_ent_hchos, t1.id_mun_hchos FROM tmp_delitos t1
										 WHERE NOT EXISTS (SELECT * FROM cat_municipios t2
															WHERE CAST(t1.id_ent_hchos AS UNSIGNED) = CAST(t2.cve_ent AS UNSIGNED)
															AND CAST(t1.id_mun_hchos AS UNSIGNED) = CAST(t2.cve_mun AS UNSIGNED) )
													AND t1.codigo_referencia = '$codRef' ")->result();
    	}

    	
    	if ($inconsistencia == 'nom_colonia_sinDato'){

    		return $this->db->query("SELECT id_ci, id_delito, dto, nom_col_hchos FROM tmp_delitos
										WHERE (nom_col_hchos IS NULL OR nom_col_hchos = '')
										AND codigo_referencia = '$codRef'")->result();
    	}

    	
    	if ($inconsistencia == 'cve_cp_incorrecta'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.dto, t1.cp FROM tmp_delitos t1
										 WHERE NOT EXISTS (SELECT * FROM cat_cp t2
															WHERE CAST(t1.cp AS UNSIGNED) = CAST(t2.d_codigo AS UNSIGNED) )
													AND t1.codigo_referencia = '$codRef'")->result();
    	}

    	
    	if ($inconsistencia == 'coord_x_fmato_incorrecto'){

    		return $this->db->query("SELECT id_ci, id_delito, dto, coord_x  FROM tmp_delitos t1 
										 WHERE  t1.coord_x <> ''
										 AND (t1.coord_x < -118 OR t1.coord_x > -86 )
										 -- AND t1.clasf_de_dto = '1.1.1' and t1.grdo_cons = 1 
										 AND t1.codigo_referencia = '$codRef';")->result();
    	}

    	
    	if ($inconsistencia == 'coord_y_fmato_incorrecto'){

    		return $this->db->query("SELECT id_ci, id_delito, dto, coord_y  FROM tmp_delitos t1 
										 WHERE t1.coord_y <> ''
										 AND (t1.coord_y < 13 OR t1.coord_y > 34 )
									     -- AND t1.clasf_de_dto = '1.1.1' and t1.grdo_cons = 1 
										 AND t1.codigo_referencia = '$codRef'; ")->result();
    	}

    	if ($inconsistencia == 'Dom_sinDato'){

    		return $this->db->query("SELECT id_ci, id_delito, dom_hchos FROM tmp_delitos 
										WHERE (dom_hchos IS NULL OR dom_hchos = '' )
										AND codigo_referencia = '$codRef'")->result();

    	}

  /**************************consultas validaciones victimas  ****************************/

    	if ($inconsistencia == 'id_ci_vict_sinDato'){

    		return $this->db->query("SELECT id_ci, id_delito FROM tmp_victimas
										WHERE (id_ci IS NULL OR id_ci = '')
										AND codigo_referencia = '$codRef'")->result();

    	}

    	
    	if ($inconsistencia == 'id_delito_vict_sinDato'){

    		return $this->db->query("SELECT id_ci, id_delito FROM tmp_victimas
										WHERE (id_delito IS NULL OR id_delito = '')
										AND codigo_referencia = '$codRef'")->result();

    	}

    	
    	if ($inconsistencia == 'id_vicf_sinDato'){

    		return $this->db->query("SELECT id_ci, id_delito, id_vicf FROM tmp_victimas
										WHERE (id_vicf IS NULL OR id_vicf = '')
										AND codigo_referencia = '$codRef'")->result();

    	}

    	if ($inconsistencia == 'ID_VICF_duplicados'){

    		return $this->db->query("SELECT id_ci, id_delito, id_vicf, COUNT(*) AS duplicados
										FROM tmp_victimas
										where codigo_referencia = '$codRef'
										GROUP BY id_ci, id_delito, id_vicf
										HAVING duplicados > 1")->result();

    	}	

    	
    	if ($inconsistencia == 'cve_tv_incorrecto'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.id_vicf, t1.id_tv FROM tmp_victimas t1
										 WHERE NOT EXISTS (SELECT * FROM cat_tipo_victima t2
															WHERE t1.id_tv = t2.clave )
													AND t1.codigo_referencia = '$codRef'")->result();

    	}

    	if ($inconsistencia == 'id_tpm_incorrecto'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.id_vicf, t1.id_tv, t1.id_tpm FROM tmp_victimas t1
										WHERE NOT EXISTS (SELECT * FROM cat_tipo_persona_moral t2
															WHERE t1.id_tpm = t2.clave )
										AND t1.id_tv = 2                     
										AND t1.codigo_referencia = '$codRef'")->result();
    	}

    	if ($inconsistencia == 'dts_incorrectos_si_es_PM'){

    		return $this->db->query(" SELECT t1.id_ci, t1.id_delito, t1.id_vicf, t1.id_tv FROM tmp_victimas t1 
										 WHERE t1.id_tv = 2 
										 AND ( t1.id_tpm not in (1,2,3,4,5,6) OR t1.sexo <> '' OR t1.genero <> '' OR t1.pob <> 4 OR  t1.disc <> 4 OR t1.fha_nac <> '' OR t1.edad <> '' OR t1.nacional <> '' )
										 AND t1.codigo_referencia = '$codRef'")->result();
    	}

    	
    	if ($inconsistencia == 'cve_sexo_incorrecto'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.id_tv, t1.sexo FROM tmp_victimas t1
										WHERE NOT EXISTS (SELECT * FROM cat_sexo t2
															WHERE t1.sexo = t2.clave )
										AND t1.id_tv = 1                     
										AND t1.codigo_referencia = '$codRef' ")->result();
    	}

    	
    	if ($inconsistencia == 'cve_genero_incorrecto'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.id_tv, t1.genero FROM tmp_victimas t1
										WHERE NOT EXISTS (SELECT * FROM cat_genero t2
															WHERE t1.genero = t2.clave )
										AND t1.id_tv = 1                     
										AND t1.codigo_referencia = '$codRef'")->result();
    	}

    	
    	if ($inconsistencia == 'dato_poblacion_incorrecto'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.id_tv, t1.pob   
									  FROM tmp_victimas t1
									  WHERE NOT EXISTS ( SELECT * FROM cat_pertenece_pob_indigena t2
															WHERE t1.pob = t2.clave )
									  AND t1.id_tv = 1 
									  AND t1.codigo_referencia  = '$codRef'")->result();
    	}


    	
    	if ($inconsistencia == 'dato_discapacidad_incorrecto'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.id_tv, t1.disc    
									  FROM tmp_victimas t1
									  WHERE NOT EXISTS ( SELECT * FROM cat_presenta_discapacidad t2
															WHERE t1.disc = t2.clave )
									  AND t1.id_tv = 1 
									  AND t1.codigo_referencia   = '$codRef'")->result();
    	}

    	
    	if ($inconsistencia == 'fmto_fchaNac_incorrecto'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.id_tv, t1.fha_nac FROM tmp_victimas t1
										WHERE fha_nac <> ''
										AND t1.id_tv = 1
										AND ( t1.fha_nac NOT REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$' OR  CAST(SUBSTRING(t1.fha_nac, 1,1) AS SIGNED) < 1 ) 
										AND codigo_referencia = '$codRef'")->result();
    	}

    	if ($inconsistencia == 'edad_incorrecto'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.id_tv, t1.edad FROM tmp_victimas t1
										WHERE NOT EXISTS (SELECT * FROM cat_edad_victima t2
															WHERE t1.edad = t2.edad)
										 AND t1.id_tv = 1                   
										 AND t1.codigo_referencia = '$codRef'")->result();
    	}


    	
    	if ($inconsistencia == 'cve_nacionalidad_incorrecto'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.id_tv, t1.nacional FROM tmp_victimas t1
										WHERE NOT EXISTS (SELECT * FROM cat_nacionalidades t2
															WHERE t1.nacional = t2.clave)
										 AND t1.id_tv = 1                   
										 AND t1.codigo_referencia = '$codRef'")->result();
    	}


    	
    	if ($inconsistencia == 'rel_vict_input_incorrecto'){

    		return $this->db->query("SELECT t1.id_ci, t1.id_delito, t1.id_tv, t1.rel_vic_vmario FROM tmp_victimas t1
										WHERE NOT EXISTS (SELECT * FROM cat_tipo_relacion t2
															WHERE t1.rel_vic_vmario = t2.clave)
										 AND t1.id_tv = 1                   
										 AND t1.codigo_referencia = '$codRef'")->result();
    	}









    }



    public function obtRegExpedientesEnviados($codRef){

    	return $this->db->query("SELECT id_ci, ntra_ci, fha_de_ini, hra_de_ini, rmen_de_hchos, usuario_reg as usuario_envio, date(fcha_insert) as fecha_envio FROM tbl_carpetas WHERE codigo_referencia = '$codRef'")->result();

    }

    public function obtRegDelitosEnviados($codRef){

		return $this->db->query("SELECT id_ci, id_delito, dto, moda_dto, forma_acc, fha_de_hchos, hra_de_hchos, emto_com_dto, grdo_cons, clasf_de_dto, nom_ent_hchos, id_ent_hchos, nom_mun_hchos, id_mun_hchos, nom_loc_hchos, id_loc_hchos, nom_col_hchos, id_col_hchos, cp, coord_x, coord_y, dom_hchos, usuario_reg as usuario_envio, date(fcha_insert) as fecha_envio
			  FROM tbl_delitos WHERE codigo_referencia = '$codRef'")->result();

    }

    public function obtRegVictimasEnviados($codRef){

	    return $this->db->query("SELECT id_ci, id_delito, id_vicf, id_tv, id_tpm, sexo, genero, pob, disc, fha_nac, edad, nacional, usuario_reg as usuario_envio, date(fcha_insert) as fecha_envio 
			FROM tbl_victimas WHERE codigo_referencia = '$codRef'")->result();

    }


    public function ConsultReg_a_reemp($anioCorte,$mesCorte){

    		return $this->db->query("SELECT * FROM tbl_carpetas
										WHERE anio_corte = '$anioCorte' and mes_corte = $mesCorte ")->result();
    }



    public function consultaPeriodoCarga($usuario) {
	    $sql = "SELECT COUNT(*) AS ExisteRegistro, codigo_referencia
	            FROM tbl_carpetas 
	            WHERE usuario_reg = ? 
	              AND YEAR(fcha_insert) = YEAR(CURRENT_DATE()) 
	              AND MONTH(fcha_insert) = MONTH(CURRENT_DATE())";

	    return $this->db->query($sql, array($usuario))->row();
	}


    public function borrarRegPrevio($usuario) {
	    $sql = "DELETE tc, td, tv
				FROM tbl_carpetas AS tc
				JOIN tbl_delitos AS td ON td.id_ci = tc.id_ci 
				    AND td.usuario_reg = '$usuario'  
				    AND YEAR(td.fcha_insert) = YEAR(CURRENT_DATE())  
				    AND MONTH(td.fcha_insert) = MONTH(CURRENT_DATE())  
				JOIN tbl_victimas AS tv ON tv.id_ci = tc.id_ci 
				    AND tv.usuario_reg = '$usuario'  
				    AND YEAR(tv.fcha_insert) = YEAR(CURRENT_DATE())  
				    AND MONTH(tv.fcha_insert) = MONTH(CURRENT_DATE())  
				WHERE tc.usuario_reg = '$usuario'
				  AND YEAR(tc.fcha_insert) = YEAR(CURRENT_DATE())
				  AND MONTH(tc.fcha_insert) = MONTH(CURRENT_DATE())";

	    $result = $this->db->query($sql, array($usuario));

	    if ($result) {
	        return $this->db->affected_rows();
	    } else {
	        return false;
	    }
	}






}	

?>