<?php 

class ConExportar extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		//cargar modelo indicado
		$this->load->library('session');
	    $this->load->model('ModActualizaDatos');
	    $this->load->model('ModSeleccionarDatos');
	    $this->load->helper('download'); // Cargar helper para descargas
	  
	}
	


	public function generar_csv_pba($codRef, $inconsistencia) {

		// $obtDatosVict = $this->ModSeleccionarDatos->obtRegInconsistencias($codRef);
	     

	      var_dump($codRef); 
	       var_dump($inconsistencia); 
         
		

	}

	
	
	public function generar_csv($codRef,$inconsistencia) {
        
        $data = $this->ModSeleccionarDatos->obtRegInconsistencias($codRef,$inconsistencia);


/******************** integridad referencial ******************************/


		if ($inconsistencia == 'tot_menosVICvsDEL'){

        	$filename = 'tot_menosVICvsDEL'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('ID_CI', 'ID_DELITO', 'total_delitos', 'total_victimas');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->ID_CI,
	                $row->ID_DELITO,
	                $row->total_delitos,
	                $row->total_victimas
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 

        if ($inconsistencia == 'tot_Reg_Carp_noExist_delit'){

        	$filename = 'tot_Reg_Carp_noExist_delit'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        if ($inconsistencia == 'tot_Reg_Carp_noExist_vict'){

        	$filename = 'tot_Reg_Carp_noExist_vict'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 

        if ($inconsistencia == 'tot_Reg_Delit_noExist_carp'){

        	$filename = 'tot_Reg_Delit_noExist_carp'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 


        if ($inconsistencia == 'tot_Reg_Delit_noExist_vict'){

        	$filename = 'tot_Reg_Delit_noExist_vict'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci','id_delito' );
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 


        if ($inconsistencia == 'tot_Reg_vict_noExist_carp'){

        	$filename = 'tot_Reg_vict_noExist_carp'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci' );
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 


        if ($inconsistencia == 'tot_Reg_vict_noExist_delit'){

        	$filename = 'tot_Reg_vict_noExist_delit'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci','id_delito' );
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }




/****************CARPETAS    ******************************************/

		
		if ($inconsistencia == 'id_ci_sinDato'){

        	$filename = 'id_ci_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 


        if ($inconsistencia == 'ID_CI_duplicados'){

        	$filename = 'ID_CI_duplicados'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'duplicados');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->duplicados
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 

        
        if ($inconsistencia == 'nomenclatura_sinDato'){

        	$filename = 'nomenclatura_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 

        
        if ($inconsistencia == 'fechaInicio_sinDato'){

        	$filename = 'fechaInicio_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci', 'fha_de_ini');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci,
	                $row->fha_de_ini
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 

        
        if ($inconsistencia == 'fmto_fechaInicio_incorrecto'){

        	$filename = 'fmto_fechaInicio_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci', 'fha_de_ini');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci,
	                $row->fha_de_ini
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 

        
        if ($inconsistencia == 'dia_fechaInicio_incorrecto'){

        	$filename = 'dia_fechaInicio_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci', 'fha_de_ini');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci,
	                $row->fha_de_ini
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 


        if ($inconsistencia == 'FHA_INI_fraRango'){

        	$filename = 'FHA_INI_fraRango'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci', 'fha_de_ini');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci,
	                $row->fha_de_ini
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'hora_ini_sinDato'){

        	$filename = 'hora_ini_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci', 'hra_de_ini');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci,
	                $row->hra_de_ini
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'fmto_hra_ini_incorrecto'){

        	$filename = 'fmto_hra_ini_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci', 'hra_de_ini');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci,
	                $row->hra_de_ini
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }


        
        if ($inconsistencia == 'cve_tipo_exp_incorrecto'){

        	$filename = 'cve_tipo_exp_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci', 'id_texp');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci,
	                $row->id_texp
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }


/*************************DELITOS**********************************************************/
		
		if ($inconsistencia == 'ID_CI_enDELITOS_null'){

        	$filename = 'ID_CI_enDELITOS_null'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	            	$row->id_ci,
	                $row->id_delito,
	                $row->dto
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'ID_DELITO_null'){

        	$filename = 'ID_DELITO_null'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	            	$row->id_ci,
	                $row->id_delito,
	                $row->dto
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }



		if ($inconsistencia == 'ID_DELITO_duplicados'){

        	$filename = 'ID_DELITO_duplicados'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'duplicados');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	            	$row->id_ci,
	                $row->id_delito,
	                $row->duplicados
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'Desc_delito_null'){

        	$filename = 'Desc_delito_null'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'dto_principal_incorrecto'){

        	$filename = 'dto_principal_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'dto_prin');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->dto_prin
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }


        if ($inconsistencia == 'CI_masdeuno_o_sin_dto_prin'){

        	$filename = 'Exp_masdeuno_o_sin_dto_prin'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto_prin');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto_prin
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }


        
        if ($inconsistencia == 'FCHA_HCHOS_incorrecta'){

        	$filename = 'FCHA_HCHOS_incorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'fha_de_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->fha_de_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }


        
        if ($inconsistencia == 'Modalidad_dto_null'){

        	$filename = 'Modalidad_dto_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'dto_prin', 'moda_dto');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->dto_prin,
	                $row->moda_dto
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }
        
        if ($inconsistencia == 'cve_formaAccionIncorrecta'){

        	$filename = 'cve_formaAccionIncorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'forma_acc');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->forma_acc
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }
        

        if ($inconsistencia == 'fcha_de_hchos_null'){

        	$filename = 'fcha_de_hchos_null'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'fha_de_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->fha_de_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'fcha_de_hchos_formatoIncorrecto'){

        	$filename = 'fcha_de_hchos_formatoIncorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'fha_de_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->fha_de_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'dia_fcha_de_hchos_Incorrecto'){

        	$filename = 'dia_fcha_de_hchos_Incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'fha_de_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->fha_de_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'long_fcha_de_hchos_Incorrecto'){

        	$filename = 'long_fcha_de_hchos_Incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'fha_de_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->fha_de_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'hora_de_hchos_sinDatos'){

        	$filename = 'hora_de_hchos_sinDatos'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'hra_de_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->hra_de_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        if ($inconsistencia == 'long_hora_hchos_incorrecto'){

        	$filename = 'long_hora_hchos_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'hra_de_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->hra_de_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'cve_emto_com_dto_incorrecta'){

        	$filename = 'cve_emto_com_dto_incorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'emto_com_dto');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->emto_com_dto
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'cve_grdo_cons_incorrecta'){

        	$filename = 'cve_grdo_cons_incorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'grdo_cons');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->grdo_cons
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'cve_clasfDelito_incorrecta'){

        	$filename = 'cve_clasfDelito_incorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'clasf_de_dto');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->clasf_de_dto
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'nombre_entidad_sinDato'){

        	$filename = 'nombre_entidad_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'nom_ent_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->nom_ent_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'cve_entFed_incorrecta'){

        	$filename = 'cve_entFed_incorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'id_ent_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->id_ent_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'nom_mun_hchos_sinDato'){

        	$filename = 'nom_mun_hchos_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'nom_mun_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->nom_mun_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'cve_mun_incorrecta'){

        	$filename = 'cve_mun_incorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'id_ent_hchos', 'id_mun_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->id_ent_hchos,
	                $row->id_mun_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'nom_colonia_sinDato'){

        	$filename = 'nom_colonia_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'nom_col_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->nom_col_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }


        
        if ($inconsistencia == 'cve_cp_incorrecta'){

        	$filename = 'cve_cp_incorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'cp');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->cp
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'coord_x_fmato_incorrecto'){

        	$filename = 'coord_x_fmato_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'coord_x');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->coord_x
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'coord_y_fmato_incorrecto'){

        	$filename = 'coord_y_fmato_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'coord_y');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->coord_y
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

         
        if ($inconsistencia == 'Dom_sinDato'){

        	$filename = 'DomHechos_vacio'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dom_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dom_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

/**************************validaciones victimas  ****************************/
     
       if ($inconsistencia == 'id_ci_vict_sinDato'){

        	$filename = 'id_ci_vict_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }   

        
        if ($inconsistencia == 'id_delito_vict_sinDato'){

        	$filename = 'id_delito_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }   

        
        if ($inconsistencia == 'id_vicf_sinDato'){

        	$filename = 'id_vicf_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_vicf');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_vicf
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 


        if ($inconsistencia == 'ID_VICF_duplicados'){

        	$filename = 'ID_VICF_duplicados'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_delito','id_vicf', 'duplicados');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_delito,
	                 $row->id_vicf,
	                $row->duplicados
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }  

        
        if ($inconsistencia == 'cve_tv_incorrecto'){

        	$filename = 'cve_tv_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci','id_delito','id_vicf', 'id_tv');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_vicf,
	                $row->id_tv
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }


        if ($inconsistencia == 'id_tpm_incorrecto'){

        	$filename = 'id_tpm_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_vicf', 'id_tv', 'id_tpm');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_vicf,
	                $row->id_tv,
	                $row->id_tpm
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);  
        }

        if ($inconsistencia == 'dts_incorrectos_si_es_PM'){

        	$filename = 'dts_incorrectos_si_es_PM_'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_vicf', 'id_tv');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_vicf,
	                $row->id_tv
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);  
        }

        
        if ($inconsistencia == 'cve_sexo_incorrecto'){

        	$filename = 'cve_sexo_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'sexo');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->sexo
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);  
        }

        
        if ($inconsistencia == 'cve_genero_incorrecto'){

        	$filename = 'cve_genero_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'genero');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->genero
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);  
        }

        
        if ($inconsistencia == 'dato_poblacion_incorrecto'){

        	$filename = 'dato_poblacion_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'pob');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->pob
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);  
        }


        
        if ($inconsistencia == 'dato_discapacidad_incorrecto'){

        	$filename = 'dato_discapacidad_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'disc');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->disc
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);  
        }

        
        if ($inconsistencia == 'fmto_fchaNac_incorrecto'){

        	$filename = 'fmto_fchaNac_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'fha_nac');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->fha_nac
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);  
        }

        if ($inconsistencia == 'edad_incorrecto'){

        	$filename = 'edad_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'edad');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->edad
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'cve_nacionalidad_incorrecto'){

        	$filename = 'cve_nacionalidad_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'nacional');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->nacional
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'rel_vict_input_incorrecto'){

        	$filename = 'rel_vict_input_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'rel_vic_vmario');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->rel_vic_vmario
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
  }


   // **************************************************************************
  // DESCARGAR EL ZIP LIMPIO Y CON CARACTERES CORRECTOS
  // **************************************************************************
   public function generar_csv_ExpedientesEnviados($codRef) {
		    // Cargar librerías necesarias
		    $this->load->library('zip');
		    $this->load->helper('download');

		    // ----------------------------------------------------
		    // Generar CSV de Expedientes
		    // ----------------------------------------------------
		    $dataExp = $this->ModSeleccionarDatos->obtRegExpedientesEnviados($codRef);
		    // Encabezados limpios
		    $headersExp = ['ID CI', 'Ntra CI', 'Fcha Inicio', 'Hora Inicio', 'Resumen Hechos', 'Usuario Envio', 'Fecha Envio'];
		    // Campos exactos de la BD
		    $camposExp = ['id_ci', 'ntra_ci', 'fha_de_ini', 'hra_de_ini', 'rmen_de_hchos', 'usuario_envio', 'fecha_envio'];
		    
		    $csvData1 = $this->_crearContenidoCSV($headersExp, $dataExp, $camposExp);


		    // ----------------------------------------------------
		    // Generar CSV de Delitos
		    // ----------------------------------------------------
		    $dataDel = $this->ModSeleccionarDatos->obtRegDelitosEnviados($codRef);
		    $headersDel = ['ID CI', 'ID Delito', 'Delito', 'Modalidad', 'Forma Accion', 'Fecha Hechos', 'Hora Hechos', 'Elemento Comision', 'Grado', 'Clasificacion', 'Entidad', 'ID Ent', 'Municipio', 'ID Mun', 'Localidad', 'ID Loc', 'Colonia', 'ID Col', 'CP', 'Coord X', 'Coord Y', 'Domicilio', 'Usuario', 'Fecha'];
		    $camposDel = ['id_ci', 'id_delito', 'dto', 'moda_dto', 'forma_acc', 'fha_de_hchos', 'hra_de_hchos', 'emto_com_dto', 'grdo_cons', 'clasf_de_dto', 'nom_ent_hchos', 'id_ent_hchos', 'nom_mun_hchos', 'id_mun_hchos', 'nom_loc_hchos', 'id_loc_hchos', 'nom_col_hchos', 'id_col_hchos', 'cp', 'coord_x', 'coord_y', 'dom_hchos', 'usuario_envio', 'fecha_envio'];
		    
		    $csvData2 = $this->_crearContenidoCSV($headersDel, $dataDel, $camposDel);


		     // ----------------------------------------------------
		    // Generar CSV de Victimas
		    // ----------------------------------------------------
		    $dataVic = $this->ModSeleccionarDatos->obtRegVictimasEnviados($codRef);
			$headersVic = ['ID CI', 'ID Delito', 'ID Vic', 'ID TV', 'ID TPM', 'Sexo', 'Genero', 'Poblacion', 'Discapacidad', 'Fcha Nac', 'Edad', 'Nacionalidad', 'Usuario', 'Fecha'];
			$camposVic = ['id_ci', 'id_delito', 'id_vicf', 'id_tv', 'id_tpm', 'sexo', 'genero', 'pob', 'disc', 'fha_nac', 'edad', 'nacional', 'usuario_envio', 'fecha_envio'];

		    $csvData3 = $this->_crearContenidoCSV($headersVic, $dataVic, $camposVic);


		    // Crear ZIP en memoria
		    $this->zip->add_data('_ExpedientesEnviados.csv', $csvData1);
		    $this->zip->add_data('_DelitosEnviados.csv', $csvData2);
		    $this->zip->add_data('_VictimasEnviados.csv', $csvData3);

		    // Generar nombre único para el ZIP
		    $zipFilename = $codRef.'_RegistrosEnviados_'.date('Ymd_His').'.zip';

		    // Forzar descarga del ZIP
		    $this->zip->download($zipFilename);

  }

   
   // --- FUNCIÓN PARA CORREGIR CARACTERES Y COMAS (USA PUNTO Y COMA) ---
   private function _crearContenidoCSV($headers, $data, $campos) {
        // Abrir un archivo temporal en memoria
        $fp = fopen('php://temp', 'r+');

        // 1. Agregar BOM para que Excel reconozca acentos y Ñ (UTF-8)
        fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

        // 2. Escribir los encabezados con separador PUNTO Y COMA
        fputcsv($fp, $headers, ';');

        // 3. Recorrer los datos y escribirlos usando fputcsv con ;
        foreach($data as $row) {
            $lineData = [];
            foreach($campos as $campo) {
                // Verificamos si es objeto o array para evitar errores
                $valor = is_object($row) ? ($row->$campo ?? '') : ($row[$campo] ?? '');
                
                // Limpieza opcional: quitar saltos de linea dentro de la celda
                $valor = preg_replace("/[\r\n]+/", " ", $valor); 
                
                $lineData[] = $valor;
            }
            // AQUI ESTA LA CLAVE: el tercer parámetro es ';'
            fputcsv($fp, $lineData, ';');
        }

        // Regresar al inicio del archivo temporal para leerlo
        rewind($fp);
        // Obtener todo el contenido como string
        $contenido = stream_get_contents($fp);
        // Cerrar el archivo temporal
        fclose($fp);

        return $contenido;
    }


}
?>